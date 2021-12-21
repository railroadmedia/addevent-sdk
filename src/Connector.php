<?php

namespace Railroad\AddEventSdk;

use Carbon\Carbon;

class Connector
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
            throw new \Exception('AddEventService CURL request response status *not* 200');
        }

        return $result;
    }
}