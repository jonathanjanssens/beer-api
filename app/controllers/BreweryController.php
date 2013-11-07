<?php

class BreweryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$brewery = Brewery::all()->take(20);
		return $brewery;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
			$error = new ErrorResponse(4040);
			$error->globalMessage('The requested record does not exist in our database');
			return $error->showError();
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}