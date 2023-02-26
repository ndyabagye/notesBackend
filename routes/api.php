<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TagsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NotesController;
use App\Http\Controllers\Api\UserAllNotesController;
use App\Http\Controllers\Api\NotesAllTagsController;
use App\Http\Controllers\Api\TagsAllNotesController;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.register');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('users', UserController::class);

        // User All Notes
        Route::get('/users/{user}/all-notes', [
            UserAllNotesController::class,
            'index',
        ])->name('users.all-notes.index');
        Route::post('/users/{user}/all-notes', [
            UserAllNotesController::class,
            'store',
        ])->name('users.all-notes.store');

        Route::apiResource('all-notes', NotesController::class);

        // Notes All Tags
        Route::get('/all-notes/{notes}/all-tags', [
            NotesAllTagsController::class,
            'index',
        ])->name('all-notes.all-tags.index');
        Route::post('/all-notes/{notes}/all-tags/{tags}', [
            NotesAllTagsController::class,
            'store',
        ])->name('all-notes.all-tags.store');
        Route::delete('/all-notes/{notes}/all-tags/{tags}', [
            NotesAllTagsController::class,
            'destroy',
        ])->name('all-notes.all-tags.destroy');

        Route::apiResource('all-tags', TagsController::class);

        // Tags All Notes
        Route::get('/all-tags/{tags}/all-notes', [
            TagsAllNotesController::class,
            'index',
        ])->name('all-tags.all-notes.index');
        Route::post('/all-tags/{tags}/all-notes/{notes}', [
            TagsAllNotesController::class,
            'store',
        ])->name('all-tags.all-notes.store');
        Route::delete('/all-tags/{tags}/all-notes/{notes}', [
            TagsAllNotesController::class,
            'destroy',
        ])->name('all-tags.all-notes.destroy');
    });

    Route::post('/sanctum/token', function (Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    });