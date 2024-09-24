package com.example.supplier;

import org.springframework.web.bind.annotation.*;
import org.springframework.http.ResponseEntity;


import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("/api/supplier")
public class SupplierController {

    @GetMapping("/availability")
    public ResponseEntity<Map<String, Object>> checkAvailability(@RequestParam String ingredient) {
        Map<String, Object> response = new HashMap<>();

        // Simulate ingredient availability
        if ("salmon".equalsIgnoreCase(ingredient)) {
            response.put("ingredient", "salmon");
            response.put("availability", true);
            response.put("price", 15.0);
            response.put("deliveryTime", "2 days");
        } else if ("tomato".equalsIgnoreCase(ingredient)) {
            response.put("ingredient", "tomato");
            response.put("availability", true);
            response.put("price", 2.5);
            response.put("deliveryTime", "1 day");
        } else {
            response.put("ingredient", ingredient);
            response.put("availability", false);
            response.put("price", 0.0);
            response.put("deliveryTime", "N/A");
        }

        return ResponseEntity.ok(response);
    }
}

