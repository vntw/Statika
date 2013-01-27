<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Console\Command;

use Statika\File\File;
use Statika\Compressor;
use Statika\Configuration\Composition;
use Statika\File\Exception\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class CompressCommand extends Command
{
    protected function configure()
    {
        $this->setName('compress')
                ->setDescription('Compresses a given composition config')
                ->addArgument('config', InputArgument::REQUIRED, 'The config file to compress');
    }

    /**
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @throws \InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $config = $input->getArgument('config');

        if (!file_exists($config)) {
            throw new FileNotFoundException('Config file ' . $config . ' not found!');
        }

        $configFile = new File($config);

        switch ($configFile->getExtension()) {
            case 'json':
                $config = new Composition\JsonCompositionConfiguration();
                break;
            default:
                throw new \InvalidArgumentException('No handler for config type ' . $configFile->getExtension() . ' available!');
        }

        $config->fromFile($configFile);

        $compressManager = new Compressor\CompressManager($config, $output, $input);
        $compressManager->handle();
    }

}
