<?php

class LoginController extends \BaseController {

	public function getIndex()
	{
		return View::make('auth.login');
	}

	public function postIndex()
	{
        $credentials = array('username' => Input::get('username'), 'password' => Input::get('password') );
		if (Auth::once($credentials)) {
            // if the user already has a record in access tokens for this app, refresh it
            //
            //
            $app_id = AuthorisedApp::where('public_token', '=', Input::get('public_token'))->first()['id'];

            $existingToken = AccessToken::where('app_id', '=', $app_id)->where('user_id', '=', Auth::user()->id)->first();
            if($existingToken) {
                AccessToken::find($existingToken->id)->delete();
            }

            $accessToken = new AccessToken;
            $accessToken->user_id = Auth::user()->id; //userid
            $accessToken->app_id = $app_id; // appid
            $returnToken = md5(time()); // random token
            $accessToken->token = $returnToken;
            $accessToken->save();
            return Redirect::to(urldecode(Input::get('redirect_url')) . '?access_token=' . $returnToken);
        }

	}

}