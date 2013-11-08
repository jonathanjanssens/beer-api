<?php

class LoginController extends \BaseController {

	public function getIndex()
	{
		return View::make('auth.login');
	}

	public function postIndex()
	{
		
	}

}