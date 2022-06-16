<?php

namespace Abolfazlrastegar\LaravelPayments\Drivers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class IdPay implements Bank
{
    /**
     * send request payment towards idpay
     * @param $amount
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function request ($api, $amount, $callbackURL, $info_user)
    {
        $request = Http::withHeaders($this->setHeaders())->post('https://api.idpay.ir/v1.1/payment', $this->setParams($amount, $callbackURL, $info_user));
        $response = json_decode($request->getBody()->getContents(), true);
        if (isset($response['error_message']) || isset($response['error_code']))
        {
            return $response['error_message'] . ':' .  $response['error_code'];
        }
        if ($api)
        {
            return $response['link'];
        }
        header('Location:' . $response['link']);exit();
    }

    /**
     * @param $param
     * @return mixed
     */
    public function verify ($params)
    {
        $request = Http::withHeaders($this->setHeaders())->post( 'https://api.idpay.ir/v1.1/payment/verify', [
                'id' => $params['id'],
                'order_id' => $params['order_id'],
        ]);
        return json_decode($request->getBody()->getContents(), true);
    }

    /**
     * @param $amount
     * @param $callbackURL
     * @return array
     */
    private function setParams ($amount, $callbackURL, $info_user)
    {
        return [
            'order_id' => time(),
            'amount' => config('payments.currency') == 'rtt' ? $amount * 10 : $amount,
            'name' => $info_user['name'],
            'phone' => $info_user['mobile'],
            'mail' => $info_user['email'],
            'desc' => config('payments.Description_payment'),
            'callback' => $callbackURL,
        ];
    }

    /**
     * @return array
     */
    private function setHeaders () {
        return [
            'Accept: application/json',
            'charset: utf-8',
            'X-API-KEY'     =>  config('payments.drivers.IdPay.key'),
            'X-SANDBOX'     =>  config('payments.Test_payment'),
        ];
    }

}
