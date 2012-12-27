<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Configuration\Composition;

use Statika\File\File;
use Statika\File\FileSet;
use Statika\Configuration\Configuration;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
abstract class CompositionConfiguration extends Configuration
{
    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $description;

    /**
     *
     * @var string
     */
    protected $inputDir;

    /**
     *
     * @var string
     */
    protected $outputDir;

    /**
     *
     * @var \Statika\File\FileSet[]
     */
    protected $fileSets = array();

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param  string                               $name
     * @return \Statika\Configuration\Configuration
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getFileSets()
    {
        return $this->fileSets;
    }

    /**
     *
     * @param  string                               $fileSets
     * @return \Statika\Configuration\Configuration
     */
    public function setFileSets($fileSets)
    {
        $this->fileSets = $fileSets;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @param array $hash
     */
    public function assignFromHash(array $hash)
    {
        $this->name = $hash['name'];
        $this->description = $hash['description'];
        $this->inputDir = $hash['inputDir'];
        $this->outputDir = $hash['outputDir'];

        $fileSets = array();

        foreach ($hash['compositions'] as $composition) {
            $fileSet = new FileSet();
            $fileSet->setOutputName($composition['outputName']);
            $fileSet->setCompressorKey($composition['compressor']);

            foreach ($composition['fileset'] as $file) {
                $src = $this->inputDir . DIRECTORY_SEPARATOR . $file;
                $fileSet->appendFile(new File($src));
            }

            $fileSets[] = $fileSet;
        }

        $this->setFileSets($fileSets);
    }

}
