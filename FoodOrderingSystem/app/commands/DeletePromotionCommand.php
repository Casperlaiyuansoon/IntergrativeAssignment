<?php
class DeletePromotionCommand implements Command {
    private $promotionModel;
    private $id;

    public function __construct(PromotionModel $promotionModel, $id) {
        $this->promotionModel = $promotionModel;
        $this->id = $id;
    }

    public function execute() {
        return $this->promotionModel->deletePromotion($this->id);
    }
}
?>
