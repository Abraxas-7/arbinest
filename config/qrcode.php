<?php

return [
    /*
    |--------------------------------------------------------------------------
    | QR Code Configuration
    |--------------------------------------------------------------------------
    |
    | Qui puoi configurare le impostazioni per la generazione dei QR code
    |
    */

    'format' => 'png',
    'size' => 300,
    'margin' => 0,
    'errorCorrection' => 'M',
    'encoding' => 'UTF-8',
    'imageType' => 'png',
    
    // Forza l'uso di GD invece di imagick
    'imageBackend' => 'gd',
    
    // Impostazioni per GD
    'backgroundColor' => [255, 255, 255],
    'foregroundColor' => [0, 0, 0],
];
