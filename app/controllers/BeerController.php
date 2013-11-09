<?php

class BeerController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$beer = Beer::all()->take(20);
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
				// $error = new ErrorResponse()
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
			$error = new ErrorResponse(4040);
			$error->globalMessage('The requested record does not exist in our database');
			return $error->showError();
		}
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
			$error = Responder::error(4040);
			$error->globalMessage('The requested record does not exist in our database');
			return $error->showError();
		}
		if($beer->delete()) {
			$response = Responder::success();
			$response->developerMessage('Record successfully deleted.')->userMessage('Beer successfully deleted.');
			return $response->showSuccess();
		}

	}

}