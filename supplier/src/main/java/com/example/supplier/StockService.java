package com.example.supplier;

import model.Stock;
import org.springframework.stereotype.Service;

@Service
public class StockService {

    public Stock getStockByFoodName(String foodName) {
        if ("Pasta".equalsIgnoreCase(foodName)) {
            return new Stock(foodName, 10); // Mock data
        } else {
            return new Stock(foodName, 0); // Out of stock
        }
    }
}





