<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::get("/todos", [TodoController::class, "index"]);
Route::post("/todos", [TodoController::class, "store"]);
Route::put("/todos/{todo}", [TodoController::class, "update"]);
Route::patch("/todos/{todo}/status", [TodoController::class, "updateStatus"]);
Route::delete("/todos/{todo}", [TodoController::class, "destroy"]);
