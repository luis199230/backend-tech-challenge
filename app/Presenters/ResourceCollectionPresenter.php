<?php

namespace App\Presenters;


trait ResourceCollectionPresenter
{
    private $status;
    private $message;

    public function responseResourceCollection($key, $data, $status = true, $message = true)
    {
        $response = [ $key => $data ];
        if($status){
            $response['status'] = $this->status;
        }
        if($message){
            $response['message'] = $this->message;
        }
        return $response;
    }

    /**
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

}
