<?php

namespace Abolfazlrastegar\LaravelPayments\Banks;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PayIr implements Bank
{
    /**
     * send request Payment towards payir
     * @param $amount
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function request($api, $amount, $callbackURL)
    {
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders($this->setHeaders())
            ->post('https://pay.ir/pg/send', $this->setParams($amount, $callbackURL));
        $response = json_decode($request->getBody()->getContents(), true);
        if (!$response['status'])
            return $response['errorMessage'];
        if ($api)
        {
            return 'https://pay.ir/pg/' . $response['token'];
        }
        header('Location:https://pay.ir/pg/' . $response['token']);exit();
    }

    /**
     * active Payment done
     * @param $Authority
     * @param $amount
     * @return mixed
     * @throws \Exception
     */
    public function verify($params)
    {
        $request = Http::withOptions(['verify' => config('payments.http_verify')])
            ->withHeaders($this->setHeaders())
            ->post('https://pay.ir/pg/verify', [
                'api' => config('payments.Test_payment') == false ? config('payments.drivers.PayIr.key') : 'test',
                'token' => $params,
            ]);
        $result = json_decode($request->getBody()->getContents(), true);
        if(isset($result['status'])){
            return $result;
        }
        return [
            'status' => false,
            'message' => "خطا در پرداخت!"
        ];
    }

    /**
     * @param $amount
     * @param $CallbackURL
     * @return array
     */
    private function setParams ($amount, $CallbackURL) {
        $user = Auth::user();
        return [
            'api' => config('payments.Test_payment') == false ? config('payments.drivers.PayIr.key') : 'test',
            'amount' => config('payments.currency') == 'rtt' ? $amount * 10 : $amount,
            'name' => $user->name .' '. $user->family,
            'mobile' => $user->mobile,
            'factorNumber' => time(),
            'description' => config('payments.Description_payment'),
            'redirect' => $CallbackURL,
        ];
    }

    /**
     * @return string[]
     */
    private function setHeaders ()
    {
        return [
            'Accept: application/json',
            'charset: utf-8',
        ];
    }
}
