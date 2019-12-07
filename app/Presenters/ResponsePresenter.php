<?php

namespace App\Presenters;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ResponsePresenter
{

    public function responseSuccess($message = '', $data = null, $meta = null, $links = null, $exception = null, $code = 200)
    {
        $response = ['status' => true, 'message' => $message];
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        if (!is_null($meta)) {
            $response['meta'] = $meta;
        }
        return response()->json($response, $code);
    }


    /**
     * @param string $message
     * @param null $data
     * @param null $exception
     * @param int $code
     * @return JsonResponse
     */
    public function responseError($message = '', $data = null, $exception = null, $code = 200)
    {
        $response = ['status' => false, 'message' => $message];
        if (!is_null($data)) {
            $response['data'] = $data;
        }
        if (!is_null($exception)) {
            if (config('app.env') == 'local') {
                $response['debug'] = $exception->getTrace();
            }
        }
        return response()->json($response, $code);
    }

    /**
     * @param $response
     * @param int $code
     * @return JsonResponse
     */
    public function responseJson($response, $code = 200)
    {
        return response()->json($response, $code);
    }

    /**
     * @param $exception
     * @return mixed
     */
    protected function extractData($exception)
    {
        $jsonObj = json_decode($exception->getResponse()->getBody());
        return isset($jsonObj->data) && !empty($jsonObj->data)?$jsonObj->data:$jsonObj;
    }


    /**
     * @param $exception
     * @return null
     */
    protected function extractMessage($exception)
    {
        $jsonObj = json_decode($exception->getResponse()->getBody());
        return isset($jsonObj->message) && !empty($jsonObj->message)?$jsonObj->message:null;
    }


    /**
     * @param string $message
     * @param ResourceCollection $collection
     * @return mixed
     */
    public function responseCollectionSuccess($message = '', ResourceCollection $collection)
    {
        return $collection->setStatus(true)->setMessage($message);
    }

}
