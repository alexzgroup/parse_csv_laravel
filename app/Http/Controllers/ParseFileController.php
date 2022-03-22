<?php

namespace App\Http\Controllers;

use App\Models\CsvFile;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class ParseFileController extends Controller
{
    private $limit = 50;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getForm(Request $request)
    {
        $page = $request->get('page');
        $data = [];

        if (!empty($page)) {
            $data['keys'] = ['year', 'industry_code', 'industry_name', 'rme_size_grp', 'variable', 'value', 'unit'];
            $data['items'] = CsvFile::paginate($this->limit);
        }

        return view('parse_file', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function parseFile(Request $request)
    {
        $file = $request->file('csv');
        $message = '';
        $destinationPath = 'uploads';
        $data = [];

        $file_system = new Filesystem;
        $file_system->cleanDirectory($destinationPath);

        if ($file) {
            CsvFile::truncate();

            $file_info = [
                'name' =>   $file->getClientOriginalName(),
                'extension' => $file->getClientOriginalExtension(),
                'real_path' => $file->getRealPath(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ];

            $file->move($destinationPath, $file->getClientOriginalName());
            $file_real_path = public_path() . '/' . $destinationPath . '/' . $file->getClientOriginalName();
            $file_data = array_map('str_getcsv', file($file_real_path));

            foreach ($file_data as $key => $row) {
                if ($key === 0) {
                    $data['keys'] = $row;
                    continue;
                }
                CsvFile::create(array_combine($data['keys'], $row));
            }

            $data['items'] = CsvFile::paginate($this->limit);

        } else {
            $file_info = null;
            $message = 'Выберите файл!';
        }

        return view('parse_file', compact('file_info', 'message', 'data'));
    }
}
