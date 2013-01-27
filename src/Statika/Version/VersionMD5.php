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

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class VersionMD5 extends Version
{
    /**
     *
     * @return string
     */
    public function getKey()
    {
        return 'md5';
    }

    /**
     * Increase the file version
     */
    public function increaseVersion()
    {
        $this->version = md5(rand(100, 1000) . uniqid() . time());
    }

    /**
     *
     * @return string
     */
    public function getRegexp()
    {
        return '[0-9a-f]{32}';
    }

    /**
     *
     * @param  string                      $file
     * @param  string                      $outputDir
     * @return \Statika\Version\VersionMD5
     */
    public function getLatestVersion($file, $outputDir)
    {
        $this->filePattern = $file;

        return $this;
    }

}
