<?php 
require_once "PaymentControl.php";

class PaymentSystem{

    public function __construct()
    {

    }

    public function pay($item)
    {
        insertPayment($item);
    }

    public function creditCardGateway(){

        // Generating a CSRF token
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        echo '<form method="post" action="/FoodOrderingSystem/app/controller/GatewayControl.php">'.
        '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">'. 

                '<div class="payment-method">'.
    '<div id="payment-input" class="payment-input">'. 
                '<div id="creditcard">
            <h3>Credit Card</h3>
        <div class="form-group" style="display: grid; margin: 30px;">
            <label for="CCardNum">Card Number:</label>
            <input type="text" name="cn" ID="CCardNum" class="form-control" ></input>
        </div>

        <div class="form-group" style="display: grid; margin: 30px;>
            <label for="CCardHold" >Card Holder Name:</label>
            <input  type="text" name="ch" ID="CCardHold" class="form-control" ></input>
        </div>

        <div class="card-detail">
            <div class="form-group" style="display: grid; margin: 30px;>
                <label for="CExpiry" >Expiry Date:</label>
                <input type="text" name="ce" ID="CExpiry" class="form-control" ></input>
            </div>

            <div class="form-group" style="display: grid; margin: 30px;>
                <label for="ccvv" >CVV:</label>
                <input type="text" name="ccvv" ID="ccvv" class="form-control" ></input>
            </div>
        </div> 
                 <button type="submit" name="proceed-gateway">Confirm</button>
        </div></div></div></form>';
    }

    public function debitCardGateway(){

        // Generating a CSRF token
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    
        echo '<form method="post" action="/FoodOrderingSystem/app/controller/GatewayControl.php">'.
        '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">'.

                '<div class="payment-method">'.
    '<div id="payment-input" class="payment-input">'. 
                '<div id="creditcard">
            <h3>Debit Card</h3>
        <div class="form-group" style="display: grid; margin: 30px;">
            <label for="CCardNum">Card Number:</label>
            <input type="number" name="cn" ID="CCardNum" class="form-control" ></input>
        </div>

        <div class="form-group" style="display: grid; margin: 30px;>
            <label for="CCardHold" >Card Holder Name:</label>
            <input  type="text" name="ch" ID="CCardHold" class="form-control" ></input>
        </div>

        <div class="card-detail">
            <div class="form-group" style="display: grid; margin: 30px;>
                <label for="CExpiry" >Expiry Date:</label>
                <input type="number" name="ce" ID="CExpiry" class="form-control" ></input>
            </div>

            <div class="form-group" style="display: grid; margin: 30px;>
                <label for="ccvv" >CVV:</label>
                <input type="number" name="ccvv" ID="ccvv" class="form-control" ></input>
            </div>
        </div> 
                 <button type="submit" name="proceed-gateway">Confirm</button>
        </div></div></div></form>';
    }

}