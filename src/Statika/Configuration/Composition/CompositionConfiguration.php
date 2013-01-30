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
     * @return \Statika\File\FileSet[]
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
    public function setFileSets(array $fileSets)
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
     * @param array $hash
     */
    public function assignFromHash(array $hash)
    {
        $this->name = $hash['name'];
        $this->description = $hash['description'];

        $fileSets = array();

        foreach ($hash['compositions'] as $composition) {
            $fileSet = new FileSet();
            $fileSet->setOutputName($composition['outputName']);
            $fileSet->setCompressorKey($composition['compressor']);
            $fileSet->setInputDir($composition['inputDir']);
            $fileSet->setOutputDir($composition['outputDir']);

            foreach ($composition['fileSet'] as $file) {
                $src = $fileSet->getInputDir() . DIRECTORY_SEPARATOR . $file;
                $fileSet->appendFile(new File($src));
            }

            $fileSets[] = $fileSet;
        }

        $this->setFileSets($fileSets);
    }

}
