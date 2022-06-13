<?php

namespace Abolfazlrastegar\LaravelPayments\Banks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Zibal implements Bank
{
    /**
     * send request Payment towards zibal
     * @param $amount
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function request($api, $amount, $callbackURL)
    {
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders($this->setHeaders())
            ->post('https://gateway.zibal.ir/v1/request', $this->setParams($amount, $callbackURL));
        $response = json_decode($request->getBody()->getContents(), true);
        if ($response['result'] !== 100) {
            return ['message' => $response['message'], 'code'   => $response['result']];
        }
        if ($api)
        {
            return 'https://gateway.zibal.ir/start/' . $response['trackId'];
        }
        header('Location:https://gateway.zibal.ir/start/' . $response['trackId']);exit();
    }

    /**
     * @param $Authority
     * @param $amount
     * @return mixed
     * @throws \Exception
     */
    public function verify($params)
    {
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders($this->setHeaders())->post('https://gateway.zibal.ir/v1/verify', [
                "merchant" => config('payments.Api_key.Zibal'),
                "trackId" => $params
            ]);
        $response = json_decode($request->getBody()->getContents(), true);
        if(isset($response['result']) && $response['result'] == 100){
            return $response;
        }
        return  [
            'status' => false,
            'message' => "پرداخت با شکست مواجه شد!"
        ];
    }

    /**
     * @param $amount
     * @param $callbackURL
     * @return array
     */
    private function setParams ($amount, $callbackURL) {
        return [
            "merchant"=> config('payments.Test_payment') == false ? config('payments.drivers.Zibal.key') : 'zibal',
            "callbackUrl"=> $callbackURL,
            "amount"=> config('payments.currency') == 'rtt' ? $amount * 10 : $amount,
            "orderId"=> time(),
            "mobile"=> Auth::user()->mobile
        ];
    }

    /**
     * @return string[]
     */
    private function setHeaders () {
        return [
            'Accept: application/json',
            'charset: utf-8',
            'Content-Type: application/json',
        ];
    }
}
