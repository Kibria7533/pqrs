<?php

return [
    'orientation' => 'P',
    'format' => 'Legal',
    'default_font' => 'kalpurush',
    'curlAllowUnsafeSslRequests' => true,
// ...
// 'font_path' => base_path('resources/fonts/'),
'font_path' => base_path('vendor/mpdf/mpdf/ttfonts'),
    'font_data' => [
        "kalpurush" => [ // bangla
            'R' => "kalpurushre.ttf",
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        "nikoshban" => [
            'R' => "NikoshBAN.ttf",
            'useOTL' => 0xFF,
            //'useKashida' => 75,
        ],
        "nikosh" => [ // bangla
            'R' => "Nikosh.ttf",
            'useOTL' => 0xFF
        ],
        "muktinarrow" => [ // bangla
            'R' => "muktinarrow.ttf",
            'B' => "muktinarrow.ttf",
            'I' => "muktinarrow.ttf",
            'BI' =>"muktinarrow.ttf",
        ],
        // ...add as many as you want.
    ]
];
