<?php

class DocsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = array(
			'beersDocs' => Doc::where('resource', '=', 'beers')->orderBy('method')->get(),
			'breweriesDocs' => Doc::where('resource', '=', 'breweries')->orderBy('method')->get(),
			'usersDocs' => Doc::where('resource', '=', 'users')->orderBy('method')->get(),
			'reviewsDocs' => Doc::where('resource', '=', 'reviews')->orderBy('method')->get()
		);

		return View::make('docs.index', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	public function show($slug)
	{
		$doc = Doc::where('slug', '=', $slug)->first();
		$data = array(
			'doc' => $doc
		);
		if($doc->is_resource == 0) {
			return View::make('docs.static', $data);
		}
		return View::make('docs.single', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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