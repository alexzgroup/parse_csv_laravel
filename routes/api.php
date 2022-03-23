<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParseFileController;
use App\Http\Resources\CsvCollection;
use App\Models\CsvFile;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/parse-file', [ParseFileController::class, 'parseFile']);
Route::post('/ajax-paginate', function () {
    return new CsvCollection(CsvFile::paginate(config('app.limit_pagination')));
});
