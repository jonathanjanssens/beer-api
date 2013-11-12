<?php

class Review extends Elegant
{

    protected $fillable = array('beer_id', 'user_id', 'smell', 'taste', 'feel', 'overall', 'detailed_review');

    protected $guarded = array();  // Important

    protected $rules = array(
        'beer_id' => 'required',
        'smell' => 'required',
        'taste' => 'required',
        'feel' => 'required'
    );
}