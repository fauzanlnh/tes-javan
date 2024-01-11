<?php

use App\Http\Controllers\Web\FamilyTreeController;
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

Route::get('/', [FamilyTreeController::class, 'index']);
Route::get('/person-create', [FamilyTreeController::class, 'create'])->name('person.create');
Route::get('/person-edit/{familyTree}', [FamilyTreeController::class, 'edit'])->name('person.edit');
Route::post('/person-add', [FamilyTreeController::class, 'store'])->name('person.add');
Route::patch('/person-update/{familyTree}', [FamilyTreeController::class, 'update'])->name('person.update');
Route::DELETE('/deletePerson/{familyTree}', [FamilyTreeController::class, 'destroy'])->name('person.delete');
