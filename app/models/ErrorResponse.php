<?php

class ErrorResponse
{

    private $errorText;
    private $userMessage;
    private $developerMessage;
    private $httpResponse;

    public function __construct($errorCode)
    {
        $error = Error::where('error_code', '=', $errorCode)->first();
        // if no error found in db give generic error
        $this->errorCode = $error->error_code;
        $this->errorText = $error->error_text;
        $this->httpResponse = $error->http_response;
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
                'errorCode' => $this->errorCode,
                'errorMessage' => $this->errorText
            )
        );
        if($this->userMessage) {
            $errorArray['error']['userMessage'] = $this->userMessage;
        }
        if($this->developerMessage) {
            $errorArray['error']['developerMessage'] = $this->developerMessage;
        }
        $errorArray['error']['moreInformation'] = URL::to('/') . '/v1/docs/error/' . $this->errorCode;
        return Response::json($errorArray, $this->httpResponse);
    }
}