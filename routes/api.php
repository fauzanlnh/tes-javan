<?php

use App\Http\Controllers\API\FamilyTreeAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

route::apiResource('person', FamilyTreeAPIController::class)->names([
    'index' => 'person.api.index',
    'create' => 'person.api.create',
    'store' => 'person.api.store',
    'show' => 'person.api.show',
    'edit' => 'person.api.edit',
    'update' => 'person.api.update',
    'destroy' => 'person.api.destroy',
]);

route::get('person/get-child/{parentId}', [FamilyTreeAPIController::class, 'getChildById'])->name('person.api.get-child-by-id');
route::get('person/get-grand-child/{grandParentId}', [FamilyTreeAPIController::class, 'getGrandChildById'])->name('person.api.get-grand-child-by-id');
route::get('person/get-aunt/{childName}', [FamilyTreeAPIController::class, 'getAuntByNephewName'])->name('person.api.get-aunt-by-nephew-name');
route::get('person/get-cousin/{childName}', [FamilyTreeAPIController::class, 'getCousinByCousinName'])->name('person.api.get-cousin-by-cousin-name');