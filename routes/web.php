<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Auth;
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



Auth::routes();



Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
Route::get('/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/store', [QuestionController::class, 'store'])->name('questions.store');
Route::get('/edit/{id}', [QuestionController::class, 'edit'])->name('questions.edit');
Route::post('/update/{id}', [QuestionController::class, 'update'])->name('questions.update');
Route::post('/delete-question/{id}', [QuestionController::class, 'destroy'])->name('questions.delete');
Route::get('user-feedback', [QuestionController::class, 'showForm'])->name('userfeedback.form');
Route::post('/user-feedabck-submit', [QuestionController::class, 'userfeedbackSubmitForm'])->name('userfeedabck.submit');

Route::get('user-feedback-list', [FeedbackController::class, 'index'])->name('userfeedback.index');
Route::get('user-feedback-view/{id}', [FeedbackController::class, 'show'])->name('userfeedbacks.view');

