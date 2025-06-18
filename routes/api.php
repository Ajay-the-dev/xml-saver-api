<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\XmlController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/generate',[TokenController::class, 'generate']);
Route::post('/getXml',[XmlController::class, 'getXml']);
Route::get('/getXmlByToday',[XmlController::class, 'getXmlByToday']);
Route::post('/saveXml',[XmlController::class, 'saveXml']);
Route::post('/removeXml',[XmlController::class, 'deleteXml']);
Route::post('/findXml',[XmlController::class, 'searchXml']);
Route::put('/editXml',[XmlController::class, 'updateXml']);




