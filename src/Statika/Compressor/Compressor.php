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

use Statika\Compressor\Manager;
use Statika\File\Aggregator;
use Statika\Version\Version;
use Statika\File\Exception\FileNotFoundException;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
abstract class Compressor
{
    /**
     *
     * @var \Statika\Compressor\Manager
     */
    protected $manager;

    /**
     *
     * @var \Statika\File\Aggregator
     */
    protected $aggregator;

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
     * @return \Statika\Compressor\Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     *
     * @param \Statika\Compressor\Manager $manager
     */
    public function setManager(Manager$manager)
    {
        $this->manager = $manager;
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
     * @param \Statika\File\Aggregator $aggregator
     */
    public function setAggregator(Aggregator $aggregator)
    {
        $this->aggregator = $aggregator;
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
     * @return int
     */
    public function getBytesBefore()
    {
        return $this->bytesBefore;
    }

    /**
     *
     * @param int $bytesBefore
     */
    public function setBytesBefore($bytesBefore)
    {
        $this->bytesBefore = $bytesBefore;
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
     * @param int $bytesAfter
     */
    public function setBytesAfter($bytesAfter)
    {
        $this->bytesAfter = $bytesAfter;
    }

    /**
     *
     * @return float
     */
    public function calculateByteAdvantage()
    {
        return (round(($this->bytesAfter / $this->bytesBefore) * 100, 2) - 100) * -1;
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
        foreach (\Statika\Statika::getConfig()->getCompressors() as $compressor) {
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

}
