<?php

return [
    /*
    |--------------------------------------------------------------------------
    | POS Printer Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define the name of your POS printer as it appears in Windows
    | "Devices and Printers" and the character column width of the paper.
    |
    */

    'name' => env('POS_PRINTER_NAME', 'XP-80C (copy 1)'),

    'chars_per_line' => env('POS_CHARS_PER_LINE', 42), // 42 for 80mm, 32 for 58mm
];
