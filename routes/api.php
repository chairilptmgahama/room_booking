<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/data/login', 'App\Http\Controllers\API\ApiController@postApiUserLogin');
