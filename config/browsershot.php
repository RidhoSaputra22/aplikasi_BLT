<?php

return [
    // Path ke binary node (opsional kalau sudah ada di PATH)
    'node_binary' => env('BROWSERSHOT_NODE_BINARY', null),

    // Path ke binary npm (opsional kalau sudah ada di PATH)
    'npm_binary' => env('BROWSERSHOT_NPM_BINARY', null),

    // Path chrome/chromium sudah kamu pakai via env
    'chrome_path' => env('BROWSERSHOT_CHROME_PATH', null),
];
