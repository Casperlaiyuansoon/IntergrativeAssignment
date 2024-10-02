<?php
class DashboardController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getDashboardData() {
        $data = [
            'totalCustomers' => $this->model->getTotalCustomers(),
            'totalMenuItems' => $this->model->getTotalMenuItems(),
            'totalOrders' => $this->model->getTotalOrders(),
            'totalSales' => $this->model->getTotalSales(),
        ];
        return $data;
    }
}

