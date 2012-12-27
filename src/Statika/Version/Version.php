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
abstract class Version
{
    /**
     *
     * @var Version[]
     */
    protected static $handlers;

    /**
     *
     * @var \Statika\File\File
     */
    protected $file;

    /**
     *
     * @var string
     */
    protected $filePattern;

    /**
     *
     * @var int
     */
    protected $version;

    /**
     *
     * @param \Statika\File\File $file
     * @param int                $version
     */
    public function __construct(File $file = null, $filePattern = null, $version = null)
    {
        $this->file = $file;
        $this->filePattern = $filePattern;
        $this->version = $version;
    }

    /**
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     *
     * @param int $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     *
     * @return \Statika\File\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     *
     * @param \Statika\File\File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    /**
     *
     * @return string
     */
    public function getFilePattern()
    {
        return $this->filePattern;
    }

    /**
     *
     * @param string $filePattern
     */
    public function setFilePattern($filePattern)
    {
        $this->filePattern = $filePattern;
    }

    /**
     *
     * @return string
     */
    abstract public function getKey();

    /**
     *
     * @return string
     */
    abstract public function getRegexp();

    abstract public function increaseVersion();

    /**
     *
     * @param string $file
     * @param string $outputDir
     */
    abstract public function getVersionForFile($file, $outputDir);

    /**
     *
     * @return string
     */
    public function getFormattedFileName()
    {
        return str_replace('{' . $this->getKey() . '}', $this->version, $this->getFilePattern());
    }

    /**
     *
     * @return Version[]
     */
    protected static function getVersionHandlers()
    {
        if (null === self::$handlers) {
            self::$handlers = array(
                new VersionMD5(),
                new VersionNumber()
            );
        }

        return self::$handlers;
    }

    /**
     *
     * @param  string                   $filePattern
     * @return \Statika\Version\Version
     * @throws \OutOfBoundsException
     */
    public static function parseVersionHandler($filePattern)
    {
        foreach (self::getVersionHandlers() as $version) {
            if (strstr($filePattern, '{' . $version->getKey() . '}')) {
                return $version;
            }
        }

        throw new \OutOfBoundsException('Unknown version handler key in pattern: ' . $filePattern);
    }

}
