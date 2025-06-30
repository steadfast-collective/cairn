<?php

use Illuminate\Support\Facades\Route;


Route::statamic('styling', 'dev.base_styling', [
    'layout' => 'layout',
    'title' => 'DEV - Base Styling'
]);


Route::group([
    'prefix' => 'mail'
], function() {
    // Add routes for mail layout testing here, for example

    // Route::get('mail/password-reset', function(){
        // return new App\Mail\PasswordReset('https://example.com', \App\Models\User::first());
    // });
});
