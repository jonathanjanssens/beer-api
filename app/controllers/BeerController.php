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
		return $beer;
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
		//
	}

}