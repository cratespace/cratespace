<?php

Route::middleware('auth')
    ->get('/kitchen-sink', function (Request $request) {
        return view('tests.kitchen-sink', compact('request'));
    });
