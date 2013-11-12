<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    return View::make('hello');
});

Route::group(array(
            'before' => 'auth',
            'prefix' => 'v1'),
        function() {

            Route::get('/', function() {
                return Redirect::to('v1/docs');
            });

            Route::resource('beers', 'BeerController');
            Route::resource('reviews', 'ReviewController');
            Route::resource('users', 'UserController');
            Route::resource('breweries', 'BreweryController');
});

Route::group(array(
            'prefix' => 'v1'),
        function() {

            Route::resource('auth', 'AuthenticationController');
            Route::resource('docs', 'DocsController');
            Route::controller('login', 'LoginController');

});