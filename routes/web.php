<?php

use App\Http\Requests\ExcelRequest;
use App\Models\CardCode;
use App\Models\ColumnOption;
use App\Models\ColumnType;
use App\Models\Documents;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use League\CommonMark\Node\Block\Document;
use Rap2hpoutre\FastExcel\FastExcel;

Auth::routes();
Route::group(['middleware' => ['auth']], __DIR__ . '/utility.php'); // * Ok 
Route::group(['middleware' => ['auth']], __DIR__ . '/approve.php'); // * Ok 
// Approve will be for the SuperUser Only 
Route::group(['middleware' => ['auth']], __DIR__ . '/customersTable.php');
Route::group(['middleware' => ['auth']], __DIR__ . '/customerData.php');
Route::group(['middleware' => ['auth']], __DIR__ . '/columnOptions.php');
Route::group(['middleware' => ['auth']], __DIR__ . '/ajax-routes.php');
Route::group(['middleware' => ['auth']], __DIR__ . '/what-if-approve.php');
Route::group(['middleware' => ['auth']], __DIR__ . '/singleCustCode.php');
Route::group(['middleware' => ['auth']], __DIR__ . '/importingRadios.php');
Route::group(['middleware' => ['auth']], __DIR__ . '/reports.php');


Route::get('/new-codes', function (Request $request) {
    $searchTerm = $request->query('search');
    $query = CardCode::query();
    if ($searchTerm) {
        $query->search($searchTerm);
    }
    $allNewCardCodes = $query->paginate(60);
    // Append the search term to the pagination links
    $allNewCardCodes->appends(['search' => $searchTerm]);

    return view('pages.new-codes', compact('allNewCardCodes'));
})->middleware('lev1')->name('new-codes-get');
