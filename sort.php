<?php
// Function to sort cars by price
function sortCarsByPrice($cars, $order) {
    
    usort($cars, function($a, $b) use ($order) {
        if ($order === 'asc') {
            return $a['price'] - $b['price'];
        } else {
            return $b['price'] - $a['price'];
        }
    });
    return $cars;
   
}

