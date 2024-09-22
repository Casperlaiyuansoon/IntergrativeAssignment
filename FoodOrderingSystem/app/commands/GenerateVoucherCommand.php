<?php
include_once 'Command.php'; // Ensure this path is correct

class GenerateVoucherCommand implements Command {
    private $voucherModel;
    private $data;

    public function __construct(VoucherModel $voucherModel, array $data) {
        $this->voucherModel = $voucherModel;
        $this->data = $data;
    }

    public function execute() {
        return $this->voucherModel->createVoucher($this->data);
    }
}
?>
