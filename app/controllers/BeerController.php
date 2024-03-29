<?php

class BeerController extends \BaseController {

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
		$beer = Beer::skip($offset)->take($limit)->get();

		foreach($beer as $key => $value) {
			$beer[$key]['thumbnail'] = URL::to('/') . '/assets/uploads/' . $beer[$key]['thumbnail'];
		}
		return $beer;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$beer = new Beer;
		if($beer->validate(Input::all())) {

			$thumbnail = $this->handleThumbnail(Input::get('thumbnail'));

			$insertArray = array(
				'name' => Input::get('name'), 
				'slug' => $this->slugify(Input::get('name')),
				'strength' => Input::get('strength'),
				'description' => Input::get('description'),
				'brewery_id' => Input::get('brewery_id'),
				'thumbnail' => $thumbnail
			);
			$newBeer = Beer::create($insertArray);
			if($newBeer) {
				$response = Responder::success()->developerMessage('New record created successfully')->userMessage('New beer added successfully.');
				return $response->showSuccess();
			}
			else {
				$response = Responder::error(500);
				return $response->returnError();
			}
		}
		$error = Responder::error(4000);
		$error->developerMessage($beer->errors());
		return $error->showError();
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
			$beer = Beer::find($id);
		}
		else {
			$beer = Beer::where('slug', '=', $id)->first();
		}
		if(!$beer) {
			$error = Responder::error(4040);
			$error->globalMessage('The requested record does not exist in our database');
			return $error->showError();
		}
		$beer['thumbnail'] = URL::to('/') . '/assets/uploads/' . $beer['thumbnail'];
		return $beer;
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
			$beer = Beer::find($id);
		}
		else {
			$beer = Beer::where('slug', '=', $id);
		}
		if(!$beer) {
			$error = Responder::error(4040);
			$error->globalMessage('The requested record does not exist in our database');
			return $error->showError();
		}
		try {
			$updates = Input::all();
			if(isset($updates['thumbnail']) && $updates['thumbnail'] != '') {
				$updates['thumbnail'] = $this->handleThumbnail(Input::get('thumbnail'));
			}
			$beer->update($updates);
		}catch(Exception $e) {
			$error = Responder::error(4005);
			return $error->showError();
		}
		return Responder::success()->globalMessage('Beer updated successfully')->showSuccess();
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
			$beer = Beer::find($id);
		}
		else {
			$beer = Beer::where('slug', '=', $id)->first();
		}
		if(!$beer) {
			return Responder::error(4040)->showError();
		}
		if($beer->delete()) {
			$response = Responder::success();
			$response->developerMessage('Record successfully deleted.')->userMessage('Beer successfully deleted.');
			return $response->showSuccess();
		}

	}

}