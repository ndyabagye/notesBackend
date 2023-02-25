<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name(
        'profile.edit'
    );
    Route::patch('/profile', [ProfileController::class, 'update'])->name(
        'profile.update'
    );
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name(
        'profile.destroy'
    );
});

Route::prefix('/')
    ->middleware('auth')
    ->group(function () {
        Route::resource('users', UserController::class);
        Route::get('all-notes', [NotesController::class, 'index'])->name(
            'all-notes.index'
        );
        Route::post('all-notes', [NotesController::class, 'store'])->name(
            'all-notes.store'
        );
        Route::get('all-notes/create', [
            NotesController::class,
            'create',
        ])->name('all-notes.create');
        Route::get('all-notes/{notes}', [NotesController::class, 'show'])->name(
            'all-notes.show'
        );
        Route::get('all-notes/{notes}/edit', [
            NotesController::class,
            'edit',
        ])->name('all-notes.edit');
        Route::put('all-notes/{notes}', [
            NotesController::class,
            'update',
        ])->name('all-notes.update');
        Route::delete('all-notes/{notes}', [
            NotesController::class,
            'destroy',
        ])->name('all-notes.destroy');

        Route::get('all-tags', [TagsController::class, 'index'])->name(
            'all-tags.index'
        );
        Route::post('all-tags', [TagsController::class, 'store'])->name(
            'all-tags.store'
        );
        Route::get('all-tags/create', [TagsController::class, 'create'])->name(
            'all-tags.create'
        );
        Route::get('all-tags/{tags}', [TagsController::class, 'show'])->name(
            'all-tags.show'
        );
        Route::get('all-tags/{tags}/edit', [
            TagsController::class,
            'edit',
        ])->name('all-tags.edit');
        Route::put('all-tags/{tags}', [TagsController::class, 'update'])->name(
            'all-tags.update'
        );
        Route::delete('all-tags/{tags}', [
            TagsController::class,
            'destroy',
        ])->name('all-tags.destroy');
    });
