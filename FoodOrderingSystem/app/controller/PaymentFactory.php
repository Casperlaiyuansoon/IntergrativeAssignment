<?php 
require_once "PaymentSystem.php";
require_once "OrderSystem.php";

class PaymentFactory{

    public function __construct()
    {
        
    }

    public static function createPayment($data, $type) {

        if ($type == "Insert") {

            $payment = new PaymentSystem();
            $payment->pay($data);
        } 

        else if($type == "Update"){

            $order = new OrderSystem();
            $order->update($data);
        }

        else if($type == "Update Status"){

            $payment = new PaymentSystem();
            $payment->update($data);
        }
        
        else {
            throw new Exception("Invalid");
        }
    }

    public static function paymentGateway($gateway){

        $payment = new PaymentSystem();

        if ($gateway == "Credit Card") {

            $payment->creditCardGateway();
        } 

        else{

            $payment->debitCardGateway();
        }
    }
}
