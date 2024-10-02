package com.example.inventory.controller;

import com.example.inventory.model.Item;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.ArrayList;
import java.util.List;

@RestController
@RequestMapping("/api")
public class InventoryController {

    // Endpoint to get inventory items
    @GetMapping("/inventory")
    public List<Item> getInventory() {
        // Create a list of inventory items
        List<Item> inventory = new ArrayList<>();
        inventory.add(new Item("Pizza", 11));
        inventory.add(new Item("Chocolate Drink", 20));
        inventory.add(new Item("Hot Dog", 15));
        inventory.add(new Item("Cake", 8));
        inventory.add(new Item("Lasagna", 12));
        inventory.add(new Item("Salmon Steak", 5));
        inventory.add(new Item("Pasta", 18));
        inventory.add(new Item("Burger", 25));

        return inventory;
    }
}
