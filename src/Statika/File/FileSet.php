<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\File;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class FileSet implements \Countable
{
    /**
     *
     * @var string
     */
    private $compressorKey;

    /**
     *
     * @var \Statika\File\File
     */
    private $files = array();

    /**
     *
     * @var string
     */
    protected $targetName;

    /**
     *
     * @var string
     */
    protected $targetBase;

    /**
     *
     * @var string|null
     */
    protected $targetSubDir;

    /**
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     *
     * @return string
     */
    public function getTargetName()
    {
        return $this->targetName;
    }

    /**
     *
     * @param  string                $targetName
     * @return \Statika\File\FileSet
     */
    public function setTargetName($targetName)
    {
        $this->targetName = $targetName;
        $this->assignTargets();

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTargetBase()
    {
        return $this->targetBase;
    }

    /**
     *
     * @param  string                $targetBase
     * @return \Statika\File\FileSet
     */
    public function setTargetBase($targetBase)
    {
        $this->targetBase = $targetBase;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTargetSubDir()
    {
        return $this->targetSubDir;
    }

    /**
     *
     * @param  string                $targetSubDir
     * @return \Statika\File\FileSet
     */
    public function setTargetSubDir($targetSubDir)
    {
        $this->targetSubDir = $targetSubDir;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCompressorKey()
    {
        return $this->compressorKey;
    }

    /**
     *
     * @param string $compressorKey
     */
    public function setCompressorKey($compressorKey)
    {
        $this->compressorKey = $compressorKey;
    }

    /**
     *
     * @return int
     */
    public function count()
    {
        return count($this->files);
    }

    /**
     *
     * @param \Statika\File\File $file
     */
    public function appendFile(File $file)
    {
        $this->files[] = $file;
    }

    /**
     * Assign targetBase and targetSubdir
     *
     * @return null
     */
    public function assignTargets()
    {
        if (!strstr($this->targetName, DIRECTORY_SEPARATOR)) {
            $this->targetBase = $this->targetName;

            return;
        }

        $delimPos = strrpos($this->targetName, DIRECTORY_SEPARATOR);

        $this->targetBase = substr($this->targetName, $delimPos + 1);
        $this->targetSubDir = substr($this->targetName, 0, $delimPos);
    }

}
