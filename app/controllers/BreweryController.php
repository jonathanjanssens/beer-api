<?php

class BreweryController extends \BaseController {


	function __construct()
	{
		$this->beforeFilter('auth', array('except' => array('index', 'show')));
		$this->beforeFilter('adminOnly', array('only' => array('destroy')));
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
		return Brewery::skip($offset)->take($limit)->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$brewery = new Brewery;
		if(Brewery::where('name', '=', Input::get('name'))->get()->count() != 0 || Brewery::where('slug', '=', $this->slugify(Input::get('name')))->get()->count() != 0) {
			return Responder::error(4004)->globalMessage('It looks like that brewery already exists')->showError();
		}
		if($brewery->validate(Input::all())) {

			$thumbnail = $this->handleThumbnail(Input::get('thumbnail'));

			$insertArray = array(
				'name' => Input::get('name'),
				'slug' => $this->slugify(Input::get('name')),
				'thumbnail' => $thumbnail,
				'description' => Input::get('description')
			);
			try{
				Brewery::create($insertArray);
				return Responder::success()->globalMessage('Brewery created successfully')->showSuccess();
			}catch(Exception $e) {
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
			$brewery = Brewery::find($id);
		}
		else {
			$brewery = Brewery::where('slug', '=', $id)->first();
		}
		if(!$brewery) {
			return Responder::error(4040)->globalMessage('The requested record does not exist in our database')->showError();
		}
		return $brewery;
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
			$brewery = Brewery::find($id);
		}
		else {
			$brewery = Brewery::where('slug', '=', $id);
		}
		if(!$brewery || $brewery->count() == 0) {
			return Responder::error(4040)->showError();
		}
		try{
			$updates = Input::all();
			if(isset($updates['thumbnail']) && $updates['thumbnail'] != '') {
				$updates['thumbnail'] = $this->handleThumbnail(Input::get('thumbnail'));
			}
			$brewery->update($updates);
		}catch(Exception $e) {
			$error = Responder::error(4005);
			return $error->showError();
		}
		return Responder::success()->globalMessage('Brewery updated successfully')->showSuccess();
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
			$brewery = Brewery::find($id);
		}
		else {
			$brewery = Brewery::where('slug', '=', $id)->first();
		}
		if(!$brewery) {
			return Responder::error(4040)->showError();
		}
		if($brewery->delete()) {
			return Responder::success()->developerMessage('Record successfully deleted.')->userMessage('Brewery successfully deleted.')->showSuccess();
		}
	}

}