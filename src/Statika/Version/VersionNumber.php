<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Version;

use Statika\File\File;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class VersionNumber extends Version
{
    /**
     *
     * @return string
     */
    public function getKey()
    {
        return 'nr';
    }

    /**
     *
     * @return string
     */
    public function getFormattedFileName()
    {
        return str_replace('{' . $this->getKey() . '}', str_pad($this->version, 4, 0, STR_PAD_LEFT), $this->getFilePattern());
    }

    public function increaseVersion()
    {
        $this->version++;
    }

    /**
     *
     * @return string
     */
    public function getRegexp()
    {
        return '([0-9]+)';
    }

    /**
     *
     * @param  string                         $file
     * @param  string                         $outputDir
     * @return \Statika\Version\VersionNumber
     */
    public function getVersionForFile($file, $outputDir)
    {
        $versions = array();
        $filePattern = str_replace(array('{version|' . $this->getKey() . '}', '.'), array($this->getRegexp(), '\.'), $file);
        $outputDir = new \DirectoryIterator($outputDir);

        foreach ($outputDir as $outputFile) {
            if ($outputFile->isFile() && preg_match('/^' . $filePattern . '$/', $outputFile->getFilename(), $matchedVersion)) {
                if (is_array($matchedVersion) && is_numeric($matchedVersion[1])) {
                    $version = clone $this;
                    $version->setFile(new File($outputFile->getRealPath()));
                    $version->setVersion((int) $matchedVersion[1]);
                    $version->setFilePattern($file);
                    $versions[$version->getVersion()] = $version;
                }
            }
        }

        if (count($versions) > 0) {
            krsort($versions, SORT_NUMERIC);
            $sortedVersions = array_values($versions);

            $latest = $sortedVersions[0];
        } else {
            $latest = clone $this;
            $latest->setFilePattern($file);
            $latest->setVersion(0);
        }

        return $latest;
    }

}
