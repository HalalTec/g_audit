<?php
return [
    'max_amount_threshold' => 50000.00,   // Flag transactions above ₦50,000
    'max_freq_threshold'   => 10,          // Flag if cashier exceeds this many transactions...
    'freq_window_minutes'  => 5,           // ...within this many minutes
];
