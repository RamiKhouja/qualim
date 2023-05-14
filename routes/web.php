<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::resource('questions', QuestionController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/admin/questions', [QuestionController::class, 'index'])->name('admin.questions');
    Route::get('/admin/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
    Route::post('/admin/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
    Route::get('/questions', [QuestionController::class, 'indexEleveur'])->name('questions');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/choices', [ChoiceController::class, 'index'])->name('admin.choices');
    Route::get('/admin/choices/create/{question_id}', [ChoiceController::class, 'create'])->name('admin.choices.create');
    Route::post('/admin/choices', [ChoiceController::class, 'store'])->name('admin.choices.store');
});

require __DIR__.'/auth.php';
