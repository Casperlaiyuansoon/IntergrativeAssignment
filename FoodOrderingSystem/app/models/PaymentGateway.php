<?php 
class PaymentGateway{
    private $paymentAmount;
    private $paymentGateway;
    private $paymentDateTime;

    public function __construct($paymentAmount, $paymentGateway, $paymentDateTime)
    {
        $this->paymentAmount = $paymentAmount;
        $this->paymentGateway = $paymentGateway;
        $this->paymentDateTime = $paymentDateTime;
    }

    public function getPaymentAmount(){

        return $this->paymentAmount;
    }

    public function getPaymentGateway(){

        return $this->paymentGateway;
    }

    public function getPaymentDateTime(){

        return $this->paymentDateTime;
    }

}