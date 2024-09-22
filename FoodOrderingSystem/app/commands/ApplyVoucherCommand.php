<?php
include_once '../models/VoucherModel.php';
include_once '../models/OrderModel.php';

class ApplyVoucherCommand implements Command {
    private $voucherModel;
    private $orderModel;
    private $voucher_code;
    private $total_amount;

    public function __construct(VoucherModel $voucherModel, OrderModel $orderModel, $voucher_code, $total_amount) {
        $this->voucherModel = $voucherModel;
        $this->orderModel = $orderModel;
        $this->voucher_code = $voucher_code;
        $this->total_amount = $total_amount;
    }

    public function execute() {
        // Retrieve the voucher from the model
        $voucher = $this->voucherModel->getVoucherByCode($this->voucher_code);

        if ($voucher) {
            if ($voucher['expiration_date'] >= date('Y-m-d') && $voucher['times_used'] < $voucher['max_uses']) {
                $discount_amount = $this->total_amount * ($voucher['discount_percentage'] / 100);
                $final_amount = $this->total_amount - $discount_amount;

                // Increment the voucher usage
                $this->voucherModel->incrementVoucherUsage($voucher['id']);

                // Save the order
                $this->orderModel->saveOrder(1 /* customer_id */, $this->total_amount, $this->voucher_code, $discount_amount, $final_amount);

                return [
                    'success' => true,
                    'message' => "Voucher applied successfully! You saved $" . number_format($discount_amount, 2) . ". Final amount: $" . number_format($final_amount, 2) . "."
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid or expired voucher code.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Voucher code not found.'
            ];
        }
    }
}
?>
