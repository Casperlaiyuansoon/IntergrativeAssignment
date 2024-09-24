package com.example.supplier.controller;

import model.Stock;
import com.example.supplier.StockService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/stocks")
public class StockController {
    
    @Autowired
    private StockService stockService;

    @GetMapping("/check")
    public Stock checkStock(@RequestParam String foodName) {
        return stockService.getStockByFoodName(foodName);
    }
}
