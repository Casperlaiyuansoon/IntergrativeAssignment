<?php
class EditPromotionCommand implements Command {
    private $promotionModel;
    private $data;

    public function __construct(PromotionModel $promotionModel, array $data) {
        $this->promotionModel = $promotionModel;
        $this->data = $data;
    }

    public function execute() {
        $today = date('Y-m-d');
        if ($this->data['start_date'] < $today) {
            return "Error: Start date cannot be in the past.";
        } elseif ($this->data['end_date'] < $today) {
            return "Error: End date cannot be in the past.";
        } elseif ($this->data['end_date'] < $this->data['start_date']) {
            return "Error: End date cannot be earlier than the start date.";
        } else {
            return $this->promotionModel->updatePromotion($this->data);
        }
    }
}
?>
