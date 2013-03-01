<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <ven@cersei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Compressor;

/**
 * @author Sven Scheffler <ven@cersei.de>
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
