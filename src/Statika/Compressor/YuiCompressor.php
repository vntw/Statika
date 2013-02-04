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
use Statika\File\FileAggregator;
use Statika\Version\Version;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class YuiCompressor extends BinaryCompressor
{
    /**
     * CTOR
     */
    public function __construct()
    {
        $this->key = 'yui';
        $this->name = 'YUI Compressor';
    }

    /**
     *
     * @param  \Statika\Version\Version  $version
     * @return null
     * @throws \InvalidArgumentException
     */
    public function compress(Version $version)
    {
        if (!$this->aggregator instanceof FileAggregator) {
            throw new \InvalidArgumentException('No aggregator provided!');
        }

        $fileSetAggregate = $this->aggregator->aggregate($this->manager->getOutput());

        $targetRawFile = $this->buildOutputPath($version, true);
        $targetMinFile = $this->buildOutputPath($version);

        if (false !== file_put_contents($targetRawFile, $fileSetAggregate)) {
            $outputRawFile = new File($targetRawFile);
            $this->bytesBefore = $outputRawFile->getSize();

            $this->manager->getOutput()->writeln(
                    sprintf('<item>- Compressing file: %s</item>', $version->getFormattedFileName())
            );

            $cmd = sprintf('java -jar %s %s -o %s', $this->getBinaryPath(), $targetRawFile, $targetMinFile);
            exec(escapeshellcmd($cmd));
            unlink($targetRawFile);

            if (file_exists($targetMinFile)) {
                $outputMinFile = new File($targetMinFile);
                $this->bytesAfter = $outputMinFile->getSize();

                return;
            }
        }

        throw new \ErrorException('Could not write to file: ' . $targetRawFile);
    }

}
