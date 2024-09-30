<?php 
class Payment{
    private $paymentID;
    private $userEmail;
    private $total;
    private $paymentAmount;
    private $paymentMethod;
    private $paymentTime;

    public function __construct($paymentID, $userEmail, $total, $paymentAmount, $paymentMethod, $paymentTime)
    {
        $this->paymentID = $paymentID;
        $this->userEmail = $userEmail;
        $this->total = $total;
        $this->paymentAmount = $paymentAmount;
        $this->paymentMethod = $paymentMethod;
        $this->paymentTime = $paymentTime;
    }

    public function __get($name) {
        return $this->$name;
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function setPayment($total, $paymentAmount, $paymentMethod, $paymentTime){
        $this->total = $total;
        $this->paymentAmount = $paymentAmount;
        $this->paymentMethod = $paymentMethod;
        $this->paymentTime = $paymentTime;

        return $this;
    }

    public function setPaymentMethod($paymentMethod):void{
        $this->paymentMethod = $paymentMethod;
    }

    public function setPaymentID($paymentID){
        $this->paymentID = $paymentID;
        return $this;
    }

    public function getPaymentId(){
        return $this->paymentID;
    }

    public function getUserEmail(){
        return $this->userEmail;
    }

    public function getTotal(){
        return $this->total;
    }

    public function getPaymentAmount(){
        return $this->paymentAmount;
    }

    public function getPaymentMethod(){
        return $this->paymentMethod;
    }

    public function getPaymentTime(){
        return $this->paymentTime;
    }
}
?>