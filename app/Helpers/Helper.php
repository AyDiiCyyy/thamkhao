<?php

namespace App\Helpers;

use App\Models\Product;

class Helper
{
    
    public static function generateProductCode()
    {
        $code = rand(0,9999999); // Generate a random 8-character code
        $code = 'BV-' . $code; // Prefix the code with 'PC-'

        // Check if the code already exists in the database
        while (Product::where('code', $code)->exists()) {
            $code = rand(0,9999999); // Generate a new code if it already exists
            $code = 'BV-' . $code; // Prefix the new code with 'PC-'
        }

        return $code; // Return the unique product code
    }
}
