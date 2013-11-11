<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
    $userAccessToken = Input::get('access_token');// get sent access token
    $appPrivateToken = Input::get('private_token');// get sent private token

    if($userAccessToken == '' && $appPrivateToken == '') {
        $error = Responder::error(4030);
        $error->developerMessage('You must provide a user access token and your app private token.');
        return $error->showError();
    }
    if($userAccessToken == '') {
        $error = Responder::error(4030);
        $error->developerMessage('You must provide a user access token.');
        return $error->showError();
    }
    if($appPrivateToken == '') {
        $error = Responder::error(4030);
        $error->developerMessage('You must provide your app private token.');
        return $error->showError();
    }

    $accessToken = AccessToken::where('token', '=', $userAccessToken)->first();
    $authorisedApp = AuthorisedApp::where('private_token', '=', $appPrivateToken)->first();

    if($authorisedApp['id'] != $accessToken['app_id']) { // check app id matches 
        $error = Responder::error(4030);
        $error->developerMessage('You sent the wrong private key for your app.');
        return $error->showError();
    }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});