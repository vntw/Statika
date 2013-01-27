<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Compressor;

use Statika\File\File;
use Statika\Version\Version;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 * @todo implement
 */
class UglifyJsCompressor extends WebserviceCompressor
{
    /**
     * CTOR
     */
    public function __construct()
    {
        $this->name = 'uglifyjs';
    }

    /**
     *
     * @param  \Statika\Version\Version  $version
     * @return null
     * @throws \InvalidArgumentException
     */
    public function compress(Version $version)
    {
        // use http api @ http://marijnhaverbeke.nl/uglifyjs
    }

}
