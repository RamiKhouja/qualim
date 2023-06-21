<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LotController;
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
    return view('home');
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

Route::middleware('admin')->group(function () {
    Route::get('/admin/questions', [QuestionController::class, 'index'])->name('admin.questions');
    Route::get('/admin/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
    Route::post('/admin/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
    Route::get('/admin/answers', [AnswerController::class, 'indexByLots'])->name('admin.answers');
    Route::put('/admin/answers/{answer}', [AnswerController::class, 'update'])->name('admin.answers.update');
    Route::put('/admin/answers/lots/{lot}', [LotController::class, 'adminValid'])->name('admin.answers.lots.update');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin/choices', [ChoiceController::class, 'index'])->name('admin.choices');
    Route::get('/admin/choices/create/{question_id}', [ChoiceController::class, 'create'])->name('admin.choices.create');
    Route::post('/admin/choices', [ChoiceController::class, 'store'])->name('admin.choices.store');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
});

Route::middleware('auth')->group(function () {
    Route::get('/questions/{lot_id}', [QuestionController::class, 'indexEleveur'])->name('questions');
    Route::post('/answers', [AnswerController::class, 'store'])->name('answers.store');
    Route::get('/lots', [LotController::class, 'myIndex'])->name('lots');
    Route::get('/lots/create', [LotController::class, 'create'])->name('lots.create');
    Route::post('/lots/store', [LotController::class, 'store'])->name('lots.store');
});

Route::middleware('collector')->group(function () {
    Route::get('/requests', [AnswerController::class, 'indexRequests'])->name('requests');
    Route::put('/requests/lots/{lot}', [LotController::class, 'destValid'])->name('requests.lots.update');
});

require __DIR__.'/auth.php';
