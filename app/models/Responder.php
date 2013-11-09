<?php

class Responder
{

    private $userMessage;
    private $developerMessage;

    private static $httpResponse;
    private static $errorCode;
    private static $errorText;

    public function __construct()
    {
        
    }

    public static function error($errorCode)
    {
        $error = Error::where('error_code', '=', $errorCode)->first();
        if(!$error) {
            self::$errorCode = 0;
            self::$errorText = 'Generic error';
            self::$httpResponse = 400;
        }
        self::$errorCode = $error->error_code;
        self::$errorText = $error->error_text;
        self::$httpResponse = $error->http_response;
        return new self;
    }

    public static function success()
    {
        return new self;
    }

    private function errorCode($code)
    {
        $this->errorCode = $code;
    }

    private function responseText($text) 
    {
        $this->responseText = $text;
    }

    private function httpResponse($response)
    {
        $this->httpResponse($response);
    }

    public function globalMessage($message)
    {
        $this->userMessage = $message;
        $this->developerMessage = $message;
        return $this;
    }

    public function userMessage($message)
    {
        $this->userMessage = $message;
        return $this;
    }

    public function developerMessage($message)
    {
        $this->developerMessage = $message;
        return $this;
    }


    public function showError()
    {
        $errorArray = array(
            'status' => 'failure',
            'error' => array(
                'errorCode' => self::$errorCode,
                'errorMessage' => self::$errorText
            )
        );
        if($this->userMessage) {
            $errorArray['error']['userMessage'] = $this->userMessage;
        }
        if($this->developerMessage) {
            $errorArray['error']['developerMessage'] = $this->developerMessage;
        }
        $errorArray['error']['moreInformation'] = URL::to('/') . '/v1/docs/error/' . self::$errorCode;
        return Response::json($errorArray, self::$httpResponse);
    }

    public function showSuccess()
    {
        $successArray = array(
                'status' => 'success'
        );
        if($this->userMessage) {
            $successArray['messages']['userMessage'] = $this->userMessage;
        }
        if($this->developerMessage) {
            $successArray['messages']['developerMessage'] = $this->developerMessage;
        }
        return Response::json($successArray, 200);
    }
}