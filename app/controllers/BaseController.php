<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function slugify($text)
	{
		$slug = strtolower($text);
		$slug = preg_replace('/[^a-z]+/i', '-', $slug);
		return $slug;
	}

	public function handleThumbnail($encodedString)
	{
		if(!$encodedString) {
			$file = 'no_thumbnail.gif';
			return $file;
		}
		$img = base64_decode($encodedString);
		$f = finfo_open();
		$mimeType = finfo_buffer($f, $img, FILEINFO_MIME_TYPE);
		$fileType = str_replace('image/', '', $mimeType);

		$uploadFolder = public_path() . '/assets/uploads/';
		$fileName = md5(time());
		$file = $fileName . '.' . $fileType;
		$filePath = $uploadFolder . $file;
		file_put_contents($uploadFolder . $file, $img);

		return $file;
	}

}