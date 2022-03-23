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
            $data['keys'] = config('app.required_fields');
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

        if ($file) {
            $data = CsvFile::parseFile($file);
            $data['keys'] = config('app.required_fields');
            $data['items'] = CsvFile::paginate($this->limit);
        } else {
            $data['error'] = 'Файл не выбран!';
        }

        // если Ajax отправим кусочек
        if ($request->post('ajax')) {
            return view('results', compact('data'));
        } else {
            return view('parse_file', compact('data'));
        }
    }
}
