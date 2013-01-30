<?php

use \Statika\Configuration\Application\JsonApplicationConfiguration;

$config = new JsonApplicationConfiguration();

$config->assignFromHash(array(
    'compressors' => array(
        array(
            'key' => 'yui',
            'map' => 'YuiCompressor',
            'path' => '/home/vntw/private/statika/res/compressors/yuicompressor-2.4.7.jar'
        ),
        array(
            'key' => 'closure',
            'map' => 'GoogleClosureCompressor',
            'path' => '/home/vntw/private/statika/res/compressors/googleclosurecompiler.jar'
        ),
        array(
            'key' => 'uglifyjs',
            'map' => 'UglifyJsCompressor',
            'url' => 'http://marijnhaverbeke.nl/uglifyjs'
        )
    )
));
