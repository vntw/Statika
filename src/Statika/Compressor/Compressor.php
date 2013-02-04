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

use Statika\Statika;
use Statika\Version\Version;
use Statika\File\Aggregator;
use Statika\File\Exception\FileNotFoundException;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
abstract class Compressor
{
    /**
     *
     * @var \Statika\Compressor\CompressManager
     */
    protected $manager;

    /**
     *
     * @var \Statika\File\Aggregator
     */
    protected $aggregator;

    /**
     *
     * @var \Statika\File\FileSet
     */
    protected $fileSet;

    /**
     *
     * @var string
     */
    protected $key;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var int
     */
    protected $bytesBefore = 0;

    /**
     *
     * @var int
     */
    protected $bytesAfter = 0;

    /**
     *
     * @return \Statika\Compressor\CompressManager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     *
     * @param  \Statika\Compressor\CompressManager $manager
     * @return \Statika\Compressor\Compressor
     */
    public function setManager(CompressManager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     *
     * @return \Statika\File\Aggregator
     */
    public function getAggregator()
    {
        return $this->aggregator;
    }

    /**
     *
     * @param  \Statika\File\Aggregator       $aggregator
     * @return \Statika\Compressor\Compressor
     */
    public function setAggregator(Aggregator $aggregator)
    {
        $this->aggregator = $aggregator;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getFileSet()
    {
        return $this->fileSet;
    }

    /**
     *
     * @param  string                         $fileSet
     * @return \Statika\Compressor\Compressor
     */
    public function setFileSet($fileSet)
    {
        $this->fileSet = $fileSet;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

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
     * @param string $key
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return int
     */
    public function getBytesBefore()
    {
        return $this->bytesBefore;
    }

    /**
     *
     * @return int
     */
    public function getBytesAfter()
    {
        return $this->bytesAfter;
    }

    /**
     *
     * @return float
     */
    public function calculateByteAdvantage()
    {
        return (round(($this->bytesAfter / $this->bytesBefore) * 100, 2) * - 1) * -1;
    }

    /**
     *
     * @var \Statika\Version\Version $version
     */
    abstract public function compress(Version $version);

    /**
     *
     * @param  string               $name
     * @return Compressor
     * @throws \OutOfRangeException
     */
    public static function getCompressor($key)
    {
        foreach (Statika::getConfig()->getCompressors() as $compressor) {
            if ($compressor['key'] === $key) {
                $compressorClass = 'Statika\Compressor\\' . $compressor['map'];
                $comp = new $compressorClass;

                if ($comp instanceof BinaryCompressor) {
                    if (!file_exists($compressor['path'])) {
                        throw new FileNotFoundException('Couldn´t locate the ' . $comp->getName() . ' compiler binary!');
                    }

                    $comp->setBinaryPath($compressor['path']);
                } elseif ($comp instanceof WebserviceCompressor) {
                    $comp->setServiceUrl($compressor['url']);
                }

                return $comp;
            }
        }

        throw new \OutOfRangeException(
                sprintf('Compressor \'%f\' doesn´t exist!', $key)
        );
    }

    /**
     * Build the output path/filename
     *
     * @param  \Statika\Version\Version $version
     * @param  bool                     $tmp
     * @return string
     */
    public function buildOutputPath(Version $version, $tmp = false)
    {
        $path = $this->manager->getConfiguration()->getOutputDir() . DIRECTORY_SEPARATOR;

        if ($this->fileSet->getTargetSubDir()) {
            $path .= $this->fileSet->getTargetSubDir() . DIRECTORY_SEPARATOR;
        }

        if ($tmp) {
            $path .= '.tmp-';
        }

        $path .= $version->getFormattedFileName();

        return $path;
    }

}
