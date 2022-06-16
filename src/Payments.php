<?php

namespace Abolfazlrastegar\LaravelPayments;

use Abolfazlrastegar\LaravelPayments\Exception\CreateErrorMessage;

class Payments
{
    /**
     * the name bank
     * @var mixed|string
     */
    protected $bank_name;

    /**
     * the amount payment
     * @var numeric
     */
    protected $amount;

    /**
     * set callbackUrl payment
     * @var string
     */
    protected $callbackURL;

    /**
     * set params method request and verify
     * @var array|string
     */
    protected $params;

    /**
     * use for api form payment
     * @var boolean
     */
    protected $api = false;

    /**
     * @param $name_bank
     * @return static
     */
    public static function create($name_bank =  '')
    {
        return new static($name_bank);
    }

    /**
     * @param $name_bank
     */
    public function __construct($name_bank = '')
    {
        $this->bank_name = $name_bank;
    }


    /**
     * set amount payment
     * @param $amount
     * @return $this
     */
    public function amount($amount)
    {
        $this->amount = $amount;

        return $this;
    }


    /**
     * set callbackUrl payment
     * @param $callbackURL
     * @return $this
     */
    public function callbackUrl ($callbackURL)
    {
        $this->callbackURL = $callbackURL;

        return $this;
    }


    /**
     * set params payment
     * @param $params
     * @return $this
     */
    public function params ($params) {
        $this->params = $params;

        return $this;
    }


    /**
     * set default bank payment
     * @return $this
     */
    public function defaultBank ()
    {
        if ($this->bank_name == '')
        {
            $this->bank_name = config('payments.Default_payment');
        }

        return $this;
    }

    /**
     * @param $api
     * @return $this
     */
    public function api ($api)
    {
        $this->api = $api;

        return $this;
    }


    /**
     * request bank for payment
     * @return mixed
     * @throws CreateErrorMessage
     */
    public function request()
    {
        $bank = $this->makeBank();
        return $bank->request($this->api, $this->amount, $this->callbackURL);
    }

    /**
     * validation payment users
     * @return mixed
     * @throws CreateErrorMessage
     */
    public function verify()
    {
        $bank = $this->makeBank();
        return $bank->verify($this->params);
    }

    /**
     * @return mixed
     * @throws CreateErrorMessage
     */
    public function checkout ()
    {
        if ($this->bank_name === 'Zarinpal')
        {
            $bank = $this->makeBank();
            return $bank->checkout($this->api, $this->amount, $this->callbackURL, $this->params);
        }
        throw CreateErrorMessage::messageNotSupportMethode($this->bank_name, 'checkout');
    }


    /**
     * @return mixed
     * @throws CreateErrorMessage
     */
    public function unVerified ()
    {
        if ($this->bank_name === 'Zarinpal')
        {
            $bank = $this->makeBank();
            return $bank->unVerified();
        }
        throw CreateErrorMessage::messageNotSupportMethode($this->bank_name, 'unVerified');
    }


    /**
     * @param $authority
     * @return mixed
     * @throws CreateErrorMessage
     */
    public function refund ($authority)
    {
        if ($this->bank_name === 'Zarinpal')
        {
            $bank = $this->makeBank();
            return $bank->refund($authority);
        }
        throw CreateErrorMessage::messageNotSupportMethode($this->bank_name, 'refund');
    }


    /**
     * @param $Bank
     * @return mixed|string
     */
    private function makeBank ()
    {
        $bank_class = 'Abolfazlrastegar\LaravelPayments\Drivers\\' . $this->bank_name;
        if (class_exists($bank_class, true))
        {
            if (config('payments.drivers.' . $this->bank_name . '.status'))
            {
                return new $bank_class();
            }
            throw CreateErrorMessage::incativeBank($this->bank_name);
        }
        throw CreateErrorMessage::notClassBank($this->bank_name, $bank_class);
    }
}
