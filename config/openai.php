<?php

return [
    'api_key' => env('OPENAI_API_KEY'),
    'defaults' => [
        'model' => 'gpt-4o-mini',
        'max_tokens' => 16384,
        'timeout' => 120, // timeout in seconds
    ],

];
