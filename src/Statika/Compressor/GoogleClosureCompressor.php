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
        $fileSetAggregate = $this->aggregator->aggregate($this->manager->getOutput());

        $outputPath = $this->buildOutputPath();

        $targetRawFile = $outputPath . DIRECTORY_SEPARATOR . '.tmp-' . $version->getFormattedFileName();
        $targetMinFile = $outputPath . DIRECTORY_SEPARATOR . $version->getFormattedFileName();

        $this->filesystem->mkdir($outputPath);

        if (false !== file_put_contents($targetRawFile, $fileSetAggregate)) {
            $outputRawFile = new File($targetRawFile);
            $this->bytesBefore = $outputRawFile->getSize();

            $this->manager->getOutput()->writeln(
                    sprintf('<item>- Compressing file: %s</item>', $version->getFormattedFileName())
            );

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
