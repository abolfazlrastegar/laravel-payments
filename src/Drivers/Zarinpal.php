<?php

namespace Abolfazlrastegar\LaravelPayments\Drivers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Zarinpal implements Bank
{
    /**
     * @param $amount
     * @param $callbackURL
     * @param $param
     * @return string|void
     */
    public function request($api, $amount, $callbackURL)
    {
        $url = $this->apiRequest();
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders($this->setHeaders())
            ->post($url['request'], $this->setParams($amount, $callbackURL));
        $response = json_decode($request->getBody()->getContents(), true);
        if (!empty($response['errors'])|| !empty($response['data']['code']) != 100){
            return $response['errors']['message'] . ':' .  $response['errors']['code'];
        }
        if ($api)
        {
            return $url['pay'] . $response['data']['authority'];
        }
        header('Location:'. $url['pay'] . $response['data']['authority']);exit();
    }


    public function checkout ($api, $amount, $callbackURL, $params)
    {

        $url = $this->apiRequest();
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders($this->setHeaders())
            ->post($url['request'], $this->setParams($amount, $callbackURL, $params));
        $response = json_decode($request->getBody()->getContents(), true);
        if (!empty($response['errors'])|| !empty($response['data']['code']) != 100){
            return $response['errors']['message'] . ':' .  $response['errors']['code'];
        }
        if ($api)
        {
            return $url['pay'] . $response['data']['authority'];
        }
        header('Location:'. $url['pay'] . $response['data']['authority']);exit();
    }

    /**
     * @return mixed|string
     */
    public function unVerified ()
    {
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders($this->setHeaders())
            ->post('https://api.zarinpal.com/pg/v4/payment/unVerified.json', ["merchant_id" => config('payments.drivers.Zarinpal.key')]);
        $response = json_decode($request->getBody()->getContents(), true);
        if (!empty($response['errors'])|| !empty($response['data']['code']) != 100){
            return $response['errors']['message'] . ':' .  $response['errors']['code'];
        }
        return $response;
    }

    /**
     * @param $authority
     * @return mixed|string
     */
    public function refund ($authority) {
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders([
                'Accept: application/json',
                'authorization:' . config('payments.drivers.Zarinpal.access_Token'),
                'Content-Type: application/json',
            ])
            ->post('https://api.zarinpal.com/pg/v4/payment/refund.json', [
                "merchant_id" => config('payments.drivers.Zarinpal.key'),
                "authority" => $authority
            ]);
        $response = json_decode($request->getBody()->getContents(), true);
//        return $response;
        if (!empty($response['errors'])){
            return $response['errors'][0]['message'] . '  ' . $response['errors'][0]['readable_code'];
        }
        return $response;
    }


    /**
     * @param $params
     * @return mixed
     */
    public function verify ($params)
    {
        $request = Http::withOptions(['verify' => config('payments.http_verify')])->withHeaders($this->setHeaders())
            ->post($this->apiVerfiy(), [
                "merchant_id" => config('payments.drivers.Zarinpal.key'),
                "authority" => $params['authority'],
                "amount" => $params['amount']
            ]);
        $result = json_decode($request->getBody()->getContents(), true);
        if(isset($result['data']['code']) && $result['data']['code'] == 100) {
            return $result;
        }
        return [
            'status' => false,
            'message' => "پرداخت با شکست مواجه شد!"
        ];
    }

    /**
     * @param $amount
     * @param $callbackURL
     * @return array
     */
    private function setParams ($amount, $callbackURL, $wages = null)
    {
        $user = Auth::user();
        $params = [
            "merchant_id" => config('payments.drivers.Zarinpal.key'),
            "amount" => $amount,
            "currency" => config('payments.currency'),
            "callback_url" => $callbackURL,
            "description" => config('payments.Description_payment'),
            "metadata" => [
                "email" => $user->email,
                "mobile" => $user->mobile
            ],
        ];
        if ($wages !== null)
        {
            $params = [
                "merchant_id" => config('payments.drivers.Zarinpal.key'),
                "amount" => $amount,
                "currency" => config('payments.currency'),
                "callback_url" => $callbackURL,
                "description" => config('payments.Description_payment'),
                "metadata" => [
                    "email" => $user->email,
                    "mobile" => $user->mobile
                ],
                "wages" => $wages
            ];
        }
        return $params;
    }

    /**
     * @return string[]
     */
    private function setHeaders ()
    {
        return [
            'Accept: application/json',
            'charset: utf-8',
            'Content-Type: application/json',
        ];
    }

    /**
     * @return string
     */
    private function apiVerfiy ()
    {
        $api = 'https://api.zarinpal.com/pg/v4/Payment/verify.json';
        if (config('payments.Test_payment'))
        {
            $api = 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json';
        }
        return $api;
    }

    /**
     * @return string[]
     */
    private function apiRequest ()
    {
        $request = 'https://api.zarinpal.com/pg/v4/payment/request.json';
        $pay = 'https://www.zarinpal.com/pg/StartPay/';
        if (config('payments.Test_payment'))
        {
            $request = 'https://sandbox.zarinpal.com/pg/v4/payment/request.json';
            $pay = 'https://sandbox.zarinpal.com/pg/StartPay/';
        }
        return [
           'request' => $request,
            'pay' => $pay
        ];
    }

}
