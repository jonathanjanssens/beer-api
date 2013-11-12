<?php

class Review extends Elegant
{

    protected $guarded = array();  // Important

    protected $rules = array(
        'beer_id' => 'required',
        'smell' => 'required',
        'taste' => 'required',
        'feel' => 'required'
    );
}