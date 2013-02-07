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
     * Get the version key
     *
     * @return string
     */
    public function getKey()
    {
        return 'nr';
    }

    /**
     * Format the version (1 => 0001)
     *
     * @return int
     */
    public function formatPrettyVersion()
    {
        return str_pad($this->version, 4, 0, STR_PAD_LEFT);
    }

    /**
     * Get the formatted file name
     *
     * @return string
     */
    public function getFormattedFileName()
    {
        return str_replace($this->getFullVersionKey(), $this->formatPrettyVersion(), $this->getFilePattern());
    }

    /**
     * Increase the version number
     */
    public function increaseVersion()
    {
        $this->version++;
    }

    /**
     * Get the regexp for the version
     *
     * @return string
     */
    public function getRegexp()
    {
        return '([0-9]+)';
    }

    /**
     * Get the latest available version
     *
     * @param  string                         $filePattern
     * @param  string                         $outputDir
     * @return \Statika\Version\VersionNumber
     */
    public function getLatestVersion($filePattern, $outputDir)
    {
        $versions = array();
        $fileRegExp = str_replace($this->getFullVersionKey(), $this->getRegexp(), $filePattern);
        $outputDir = new \DirectoryIterator($outputDir);

        foreach ($outputDir as $outputFile) {
            if ($outputFile->isFile() && preg_match('/^' . $fileRegExp . '$/', $outputFile->getFilename(), $matchedVersion)) {
                if (is_array($matchedVersion) && is_numeric($matchedVersion[1])) {
                    $version = clone $this;
                    $version->setFile(new File($outputFile->getRealPath()));
                    $version->setVersion((int) $matchedVersion[1]);
                    $version->setFilePattern($filePattern);
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
            $latest->setFilePattern($filePattern);
            $latest->setVersion(0);
        }

        return $latest;
    }

}
