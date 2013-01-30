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
    private $outputName;

    /**
     *
     * @var string
     */
    private $outputDir;

    /**
     *
     * @var string
     */
    private $inputDir;

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
    public function getOutputName()
    {
        return $this->outputName;
    }

    /**
     *
     * @param string $outputName
     */
    public function setOutputName($outputName)
    {
        $this->outputName = $outputName;
    }

    /**
     *
     * @return string
     */
    public function getOutputDir()
    {
        return $this->outputDir;
    }

    /**
     *
     * @param string $outputDir
     */
    public function setOutputDir($outputDir)
    {
        $this->outputDir = $outputDir;
    }

    /**
     *
     * @return string
     */
    public function getInputDir()
    {
        return $this->inputDir;
    }

    /**
     *
     * @param string $inputDir
     */
    public function setInputDir($inputDir)
    {
        $this->inputDir = $inputDir;
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

}
