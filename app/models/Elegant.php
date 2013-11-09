<?php

class Elegant extends Eloquent
{
    protected $rules = array();

    protected $errors;

    public function validate($data)
    {
        $validator = Validator::make($data, $this->rules);

        if($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    public function errors()
    {
        $errors = '';
        foreach ($this->errors->all() as $message) {
            $errors .= $message . ' ';
        }
        return $errors;
    }
}