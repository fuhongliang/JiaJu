<?php
$mode = env('YII_ENV');

if ($mode == 'prod') {
    $config = [
        'jiaJuApi' => [
            'host' => 'https://jiajuapi.ifhu.cn',
            'key' => 'web',
            'secret' => '*92323sfss*723232sosspwe',
        ],
    ];
} else {
    $config = [
        'jiaJuApi' => [
            'host' => 'https://testjiajuapi.ifhu.cn',
            'key' => 'web',
            'secret' => '*92323sfss*723232sosspwe',
        ],
    ];
}
return $config;