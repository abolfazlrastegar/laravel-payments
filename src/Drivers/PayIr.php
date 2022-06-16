<?php

namespace Abolfazlrastegar\LaravelPayments\Drivers;

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
    public function request($api, $amount, $callbackURL, $info_user)
    {
        $request = Http::withHeaders($this->setHeaders())
            ->post('https://pay.ir/pg/send', $this->setParams($amount, $callbackURL, $info_user));
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
        $request = Http::withHeaders($this->setHeaders())
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
    private function setParams ($amount, $CallbackURL, $info_user) {
        return [
            'api' => config('payments.Test_payment') == false ? config('payments.drivers.PayIr.key') : 'test',
            'amount' => config('payments.currency') == 'rtt' ? $amount * 10 : $amount,
            'name' => $info_user['name'],
            'mobile' => $info_user['mobile'],
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
