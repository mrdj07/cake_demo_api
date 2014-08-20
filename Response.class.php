<?php

class Response{

    private $code;

    private $message;

    /**
     * @param $code HTTP Response code
     * @param string $message Response Message
     * @param string $type Content-Type
     * @param null $data Response Data
     */
    function __construct($code, $message = " ", $type = "text/html", $data = NULL){
        $this->code = $code;
        $this->message = $message;
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Sends response.
     */
    public function send(){
        header($this->message, true, $this->code);
        header('Content-type: '.$this->type);
        echo json_encode(array('message'=>$this->message, 'data' => $this->data));
        die();
    }
}
