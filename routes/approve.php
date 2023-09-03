<?php

use App\Http\Controllers\ApproveController;
use App\Models\EditHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/approve', [ApproveController::class, 'approveField'])->name('approve');
Route::post('/approve-all', [ApproveController::class, 'approveAll'])->name('approve-all');
Route::get('/history-log', function () {
    $allHistory = EditHistory::orderBy('updated_at', 'desc')->paginate(12);
    return view('pages.history-log', compact(['allHistory']));
})->name('history-log');



Route::get('/editor-approval-history', function (Request $request) {
    $allHistory = EditHistory::where('editor_id', request()->user()->id)->orderBy('updated_at', 'desc')->paginate(12);
    return view('pages.history-log', compact(['allHistory']));
})->name('editor-approval-history');
