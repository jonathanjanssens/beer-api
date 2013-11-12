<?php

class UserController extends \BaseController {

	function __construct()
	{
		$this->beforeFilter('auth', array('except' => array('index', 'show')));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		(isset($_GET['limit']) && $_GET['limit'] < 201) ? $limit = $_GET['limit'] : $limit = 20;
		(isset($_GET['offset'])) ? $offset = $_GET['offset'] : $offset = 0;
		return User::skip($offset)->take($limit)->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = new User;
		if(User::where('username', '=', Input::get('username'))->count() != 0 || User::where('email', '=', Input::get('email'))->count() != 0) {
			return Responder::error(4004)->globalMessage('It looks like that user already exists')->showError();
		}
		if($user->validate(Input::all())) {
			$insertArray = array(
				'username' => Input::get('username'),
				'password' => Hash::make('password'),
				'email' => Input::get('email')
			);
			try {
				User::create($insertArray);
				return Responder::success()->globalMessage('Account created successfully')->showSuccess();
			} catch(Exception $e) {
				$error = Responder::error(4005);
				return $error->showError();
			}
		}
		return Responder::error(4000)->developerMessage($brewery->errors())->showError();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(is_numeric($id)){
			$user = User::find($id);
		}
		else {
			$user = User::where('username', '=', $id)->first();
		}
		if(!$user) {
			return Responder::error(4040)->globalMessage('The requested record does not exist in our database')->showError();
		}
		return $user;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(is_numeric($id)){
			$user = User::find($id);
		}
		else {
			$user = User::where('username', '=', $id);
		}
		if(!$user || $user->count() == 0) {
			return Responder::error(4040)->showError();
		}
		try{
			$updates = Input::all();
			if(isset($updates['password']) && $updates['password'] != '') {
				$updates['password'] = Hash::make($updates['password']);
			}
			$user->update($updates);
		}catch(Exception $e) {
			return Responder::error(4005)->showError();
		}
		return Responder::success()->globalMessage('User updated successfully')->showSuccess();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(is_numeric($id)){
			$user = User::find($id);
		}
		else {
			$user = User::where('usernme', '=', $id)->first();
		}
		if(!$user) {
			return Responder::error(4040)->showError();
		}
		if($user->delete()) {
			return Responder::success()->developerMessage('Record successfully deleted.')->userMessage('User successfully deleted.')->showSuccess();
		}
	}

}