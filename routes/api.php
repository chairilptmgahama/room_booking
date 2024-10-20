<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/data/login', 'App\Http\Controllers\API\ApiController@postApiUserLogin');

Route::post('/v1/booking/room', 'App\Http\Controllers\API\ApiController@postApiBookingRoom');
Route::post('/v1/booking/participant', 'App\Http\Controllers\API\ApiController@postApiBookingParticipant');
Route::post('/v1/booking/memo', 'App\Http\Controllers\API\ApiController@postApiBookingMemo');
Route::post('/v1/mybooking', 'App\Http\Controllers\API\ApiController@postApiMyScheduleBooking');
