# simple-api-sign

![npm version](https://img.shields.io/badge/version-1.0.0-brightgreen)

Simple API sign is a simple implementation of API signature. It now includes JS and PHP versions with corresponding create and check methods.General projects can be used out of the box, but I do not guarantee the security of this method and the repair of future events.this module is very simple. You might as well look at the source code.

This module is mainly for my own use. When the data from the front-end (usually JavaScript projects) is sent to the back-end (PHP and python), the back-end will verify the data. The creation of token is omitted here because there are many open and general standards for the construction of token.

Finally, the timestamp and random string added to the data may be used for other purposes. That's it for the time being.

## Others

javascript version See [NPM](https://www.npmjs.com/package/simple-api-sign).


## Install

```
composer require pebm/simple-api-sign
```

## Usage

```php

require "vendor/autoload.php";

use SimpleApiSign\SimpleApiSign as ApiSign;

$data = [
    'source'    => 'products',
    'pk'        => 1003443,
    'ext'       => [
        'sales', 'pv', 'uv'
    ],
    'x' => [
        'x'     => 23,
        'few'   => [
            'fs'    => [0,2,3]
        ]
    ]
];

$apiSign = new ApiSign;

$token = 'xx';

$signData = $apiSign->create($data, $token);

/** signData like this
 Array
(
    [source] => products
    [pk] => 1003443
    [ext] => Array
        (
            [0] => sales
            [1] => pv
            [2] => uv
        )
    [x] => Array
        (
            [x] => 23
            [few] => Array
                (
                    [fs] => Array
                        (
                            [0] => 0
                            [1] => 2
                            [2] => 3
                        )
                )
        )
    [timestamp] => 1645365617000
    [random] => 208086
    [sign] => 72BDDFD9993072EE4EBE63C451F138E3
)
 */

$isValid = $apiSign->check($a, $token);

// your code ...
```