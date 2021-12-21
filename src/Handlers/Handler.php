<?php

namespace Railroad\AddEventSdk\Handlers;

use Carbon\Carbon;
use Railroad\AddEventSdk\Helpers;

class Handler
{
    /**
     * @var string
     */
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = config('addevent-sdk.api-token');
    }

    /**
     * @param $url
     * @return array|bool|mixed|object
     * @throws \Exception
     */
    public function curl($url)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        if (empty($buffer)) {
            return false;
        }
        $result = json_decode($buffer);

        $status = $result->meta->code;

        if ($status !== '200') {
            if(isset($result->meta->error_message)){
                $msg = 'AddEventService CURL request response status ' . $status .
                    ' rather than expected 200. Error message: ' . '"' . $result->meta->error_message . '"';
            }

            throw new \Exception($msg ?? 'AddEventService CURL request response status *not* expected 200');
        }

        return $result;
    }
}