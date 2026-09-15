<?php

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.categories.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});
