<?php

namespace App\Http\Controllers;

use App\Models\CsvFile;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;

class ParseFileController extends Controller
{
    private $url_ajax_pagination = '/api/ajax-paginate';

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getForm(Request $request)
    {
        $page = $request->get('page');
        $data = [];

        if (!empty($page)) {
            $data['keys'] = config('app.required_fields');
            $data['items'] = CsvFile::paginate(config('app.limit_pagination'));
        }

        return view('parse_file', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function parseFile(Request $request)
    {
        $file = $request->file('csv');
        $data = [];

        if ($file) {
            $data = CsvFile::parseFile($file);
            $data['keys'] = config('app.required_fields');
            $data['items'] = CsvFile::paginate(config('app.limit_pagination'));
        } else {
            $data['error'] = 'Файл не выбран!';
        }

        $data['url_ajax_pagination'] = $this->url_ajax_pagination;

        // если Ajax отправим кусочек
        if ($request->post('ajax')) {
            if (!empty($data['items'])) {
                $data['items']->withPath(url('/') . $this->url_ajax_pagination);
                $data['items']->appends(['ajax' => 1]);
            }
            return view('results', compact('data'));
        } else {
            return view('parse_file', compact('data'));
        }
    }
}
