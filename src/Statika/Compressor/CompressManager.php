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

use Statika\Compressor\Compressor;
use Statika\Configuration\Configuration;
use Statika\File\FileAggregator;
use Statika\Version\Version;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class CompressManager
{
    /**
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    private $input;

    /**
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     *
     * @var \Statika\Configuration\Configuration
     */
    private $configuration;

    /**
     * CTOR
     *
     * @param \Statika\Configuration\Configuration              $config
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(Configuration $config, OutputInterface $output, InputInterface $input)
    {
        $this->configuration = $config;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     *
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     *
     * @return \Statika\Configuration\Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     *
     * @param \Statika\Configuration\Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Handle the config filesets
     */
    public function handle()
    {
        foreach ($this->configuration->getFileSets() as $fileSet) {
            $versionHandler = Version::parseVersionHandler($fileSet->getOutputName());

            $version = $versionHandler->getVersionForFile($fileSet->getOutputName(), $this->configuration->getOutputDir());
            $version->increaseVersion();

            $aggregator = new FileAggregator();
            $aggregator->setFileSet($fileSet)
                    ->setOutput($this->output);

            $compressor = Compressor::getCompressor($fileSet->getCompressorKey());
            $compressor->setManager($this)
                    ->setAggregator($aggregator)
                    ->compress($version);

            $this->output->writeln(
                    sprintf('<info>Successfully compressed the fileset! You saved %s%% in filesize!</info>', $compressor->calculateByteAdvantage())
            );
        }
    }

}
