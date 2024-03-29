<?php

class ReviewController extends \BaseController {

	function __construct()
	{
		$this->beforeFilter('auth', array('except' => array('index', 'show')));
		$this->beforeFilter('adminOnly', array('only' => array('update')));
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
		return Review::skip($offset)->take($limit)->get();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(!Beer::find(Input::get('beer_id'))) {
			$error = Responder::error(4040)->developerMessage('Beer does not exist, you cannot leave a beer for a beer not in our database');
			return $error->showError();
		}
		$existingReview = Review::where('beer_id', '=', Input::get('beer_id'))->where('user_id', '=', User::auth()['id'])->count();
		if($existingReview != 0) {
			return Responder::error(4004)->developerMessage('A user may only review each individual beer once')->userMessage('You have already reviewed this beer, you may only review each once')->showError();
		}
		$review = new Review;

		if($review->validate(Input::all())) {
			$overall = number_format(((Input::get('smell') + Input::get('taste') + Input::get('feel')) / 3), 2);
			$insertArray = array(
				'beer_id' => Input::get('beer_id'),
				'user_id' => User::auth()['id'],
				'smell' => Input::get('smell'),
				'taste' => Input::get('taste'),
				'feel' => Input::get('feel'),
				'overall' => $overall,
				'detailed_review' => Input::get('detailed_review')
			);
			$newReview = Review::create($insertArray);
			if($newReview) {
				$response = Responder::success()->developerMessage('New record created successfully')->userMessage('New review added successfully.');
				$user = User::find(User::auth()['id']);
				$count = $user->reviews_count + 1;
				$user->reviews_count = $count;
				$user->save();
				return $response->showSuccess();
			}
			else {
				$response = Responder::error(500);
				return $response->returnError();
			}
		}
		$error = Responder::error(4000);
		$error->developerMessage($review->errors());
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
		$review = Review::find($id);
		if(!$review) {
			$error = Responder::error(4040);
			$error->globalMessage('The requested item does not exist in our database');
			if(!is_numeric($id)) {
				$error->developerMessage('Review IDs must be numeric');
			}
			return $error->showError();
		}
		return $review;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$review = Review::find($id);
		if(!$review) {
			return Responder::error(4040)->globalMessage('Cannot edit a review that does not exist')->showError();
		}
		if($review['user_id'] == User::auth()['id'] || User::auth()['admin_level'] != 0) {
			try {
				$updates = Input::all();
				$review->update($updates);
			} catch(Exception $e) {
				return Responder::error(4005)->showError();
			}
		}
		else {
			return Responder::error(4031)->showError();
		}
		$review = Review::find($id);
		$newOverall = number_format(($review->smell + $review->feel + $review->taste) / 3, 2);
		$review->update(array('overall' => $newOverall));
		return Responder::success()->globalMessage('Review updated successfully')->showSuccess();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$review = Review::find($id);
		if(!$review) {
			$error = Responder::error(4040);
			$error->globalMessage('The requested item does not exist in our database');
			if(!is_numeric($id)) {
				$error->developerMessage('Review IDs must be numeric');
			}
			return $error->showError();
		}
		if($review['user_id'] == User::auth()['id'] || User::auth()['admin_level'] != 0) {
			$review->delete();
			return Responder::success()->globalMessage('Review deleted successfully')->showSuccess();
		}
		return Responder::error(4031)->userMessage('You cannot delete a review that does not belong to you')->showError();
	}

}