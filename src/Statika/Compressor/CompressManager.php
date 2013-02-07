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

use Statika\Version\Version;
use Statika\File\FileAggregator;
use Statika\Configuration\Composition\CompositionConfiguration;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class CompressManager
{
    /**
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     *
     * @var \Statika\Configuration\Composition\CompositionConfiguration
     */
    private $configuration;

    /**
     * CTOR
     *
     * @param \Statika\Configuration\Composition\CompositionConfiguration $config
     * @param \Symfony\Component\Console\Output\OutputInterface           $output
     */
    public function __construct(CompositionConfiguration $config, OutputInterface $output)
    {
        $this->configuration = $config;
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
     * @return \Statika\Configuration\Composition\CompositionConfiguration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     *
     * @param \Statika\Configuration\Composition\CompositionConfiguration $configuration
     */
    public function setConfiguration(CompositionConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Handle the config filesets
     */
    public function handle()
    {
        $fileSets = $this->configuration->getFileSets();

        foreach ($fileSets as $fileSet) {
            /* @var $fileSet \Statika\File\FileSet */

            $versionHandler = Version::parseVersionHandler($fileSet->getTargetBase());
            $targetOutputDir = $this->getConfiguration()->getOutputDir() . $fileSet->getTargetSubDir();

            $version = $versionHandler->getLatestVersion($fileSet->getTargetBase(), $targetOutputDir);
            $version->increaseVersion();

            $compressor = Compressor::getCompressor($fileSet->getCompressorKey());

            $this->output->writeln(
                    sprintf('<headline><> Starting compression of output file \'%s\'</headline>', $version->getFormattedFileName())
            );
            $this->output->writeln(
                    sprintf('<info>   (%d files, using %s)</info>', $fileSet->count(), $compressor->getName())
            );

            $aggregator = new FileAggregator();
            $aggregator->setFileSet($fileSet)
                    ->setOutput($this->output);

            $compressor->setManager($this)
                    ->setAggregator($aggregator)
                    ->setFileSet($fileSet)
                    ->setFilesystem(new Filesystem())
                    ->compress($version);

            $this->output->writeln(
                    sprintf('<result><> Successfully compressed the fileset! You saved %s%% in filesize!</result>', $compressor->calculateByteAdvantage())
            );

            if ($fileSet !== end($fileSets)) {
                $this->output->write(PHP_EOL);
            }
        }
    }

}
