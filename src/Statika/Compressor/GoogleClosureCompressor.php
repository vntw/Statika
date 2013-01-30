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
class GoogleClosureCompressor extends BinaryCompressor
{
    /**
     * CTOR
     */
    public function __construct()
    {
        $this->key = 'closure';
        $this->name = 'Google Closure Compiler';
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

        $targetRawFile = $this->fileSet->getOutputDir() . DIRECTORY_SEPARATOR . '.tmp-' . $version->getFormattedFileName();
        $targetMinFile = $this->fileSet->getOutputDir() . DIRECTORY_SEPARATOR . $version->getFormattedFileName();

        if (false !== file_put_contents($targetRawFile, $fileSetAggregate)) {
            $outputRawFile = new File($targetRawFile);
            $this->bytesBefore = $outputRawFile->getSize();

            //  --compilation_level ADVANCED_OPTIMIZATIONS
            $cmd = sprintf('java -jar %s --js %s --js_output_file %s', $this->getBinaryPath(), $targetRawFile, $targetMinFile);
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
