<?php

use App\Http\Livewire\Shows;
use App\Http\Livewire\Users;
use App\Http\Controllers\Feed;
use App\Http\Controllers\Home;
use App\Http\Livewire\Episodes;
use App\Http\Controllers\Episode;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', Home::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/feed/{id}', Feed::class)->name('feed');
Route::get('/episode/{id}', Episode::class)->name('episode');

Route::middleware('auth:admin')->get('/admin/users', Users::class);
Route::middleware('auth')->get('/admin/shows', Shows::class)->name('admin.shows');
Route::middleware('auth')->get('/admin/episodes/{id}', Episodes::class)->name('admin.episodes');
