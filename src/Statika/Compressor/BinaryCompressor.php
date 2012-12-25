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

use Statika\Compressor\Compressor;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
abstract class BinaryCompressor extends Compressor
{
    /**
     *
     * @var string
     */
    protected $binaryPath;

    /**
     *
     * @return string
     */
    public function getBinaryPath()
    {
        return $this->binaryPath;
    }

    /**
     *
     * @param string $binaryPath
     */
    public function setBinaryPath($binaryPath)
    {
        $this->binaryPath = $binaryPath;
    }

}
