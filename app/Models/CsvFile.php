<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;

class CsvFile extends Model
{
    protected $table = 'csv';
    protected $fillable = ['year', 'industry_code', 'industry_name', 'rme_size_grp', 'variable', 'value', 'unit'];

    /**
     * @param $file
     * @return array
     */
    public static function parseFile($file) : array
    {
        $destinationPath = 'uploads';
        $data = [];

        // чистим директорию для удобства
        $file_system = new Filesystem;
        $file_system->cleanDirectory($destinationPath);

        $data['file_info'] = [
            'name' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'real_path' => $file->getRealPath(),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];

        $file->move($destinationPath, $file->getClientOriginalName());
        $file_real_path = public_path() . '/' . $destinationPath . '/' . $file->getClientOriginalName();
        $file_data = array_map('str_getcsv', file($file_real_path));

        if (!empty(array_diff(config('app.required_fields'), $file_data[0]))) {
            $data['error'] = 'Отсутствуют поля' . implode(',', array_diff(config('app.required_fields'), $file_data[0]));
        }

        //если всё хорошо распарсим файл
        if (empty($data['error'])) {
            CsvFile::truncate();
            foreach ($file_data as $row) {
                CsvFile::create(array_combine(config('app.required_fields'), $row));
            }
        }

        return $data;
    }
}
