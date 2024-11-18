<?php

use App\Http\Controllers\TopListController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TopListController::class, "index"])->name("home");
Route::get('/toplist', [TopListController::class, "toplist"])->name("toplist.toplist");
Route::get('/categories/{category_name}', [TopListController::class, "category"])->name("toplist.category");
Route::get('/categories', [TopListController::class, "categories"])->name("toplist.categories");
Route::get('/films', [TopListController::class, "films"])->name("toplist.films");
Route::get('/tvs', [TopListController::class, "tvs"])->name("toplist.tvs");
Route::get('/popular', [TopListController::class, "popular"])->name("toplist.popular");
Route::get('/week/{week}', [TopListController::class, "week"])->name("toplist.week")->where(["week" => "((19[0-9]{2})|(2[0-9]{3}))-((0[1-9]{1})|(1[012]{1}))-((0[1-9]{1})|([12]{1}[0-9]{1})|(3[01]{1}))"]);
Route::get('/top1/{week}', [TopListController::class, "top1"])->name("toplist.top1")->where(["week" => "((19[0-9]{2})|(2[0-9]{3}))-((0[1-9]{1})|(1[012]{1}))-((0[1-9]{1})|([12]{1}[0-9]{1})|(3[01]{1}))"]);
