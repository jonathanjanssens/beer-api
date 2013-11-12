<?php

class Brewery extends Elegant
{

    protected $guarded = array();  // Important

    protected $rules = array(
        'name' => 'required',
        'description' => 'required'
    );

    public static function doesExist($id) {
        if(is_numeric($id)){
            $brewery = self::find($id);
        }
        else {
            $brewery = self::where('slug', '=', $id);
        }
        if(!$brewery || $brewery->count() == 0) {
            return null;
        }
        return $brewery;
    }
}