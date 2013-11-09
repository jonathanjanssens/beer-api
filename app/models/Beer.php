<?php

class Beer extends Elegant
{
    protected $fiilable = array(
        'name', 'slug', 'stregth', 'description', 'brewery_id', 'thumbnail'
    );

    protected $guarded = array();  // Important

    protected $rules = array(
        'name' => 'required',
        'strength' => 'required',
        'description' => 'required',
        'brewery_id' => 'required'
    );
}