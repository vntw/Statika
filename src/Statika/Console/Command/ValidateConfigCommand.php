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
use Statika\Configuration\Composition\JsonCompositionConfiguration;
use Statika\Configuration\Validator\Exception\ValidatorException;
use Statika\Configuration\Validator\FileExistsValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class ValidateConfigCommand extends Command
{
    protected function configure()
    {
        $this->setName('validate')
                ->addArgument('config', InputArgument::REQUIRED, 'The config file to validate');
    }

    /**
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $input->getArgument('config');

        if (file_exists($config)) {
            $configFile = new File($config);

            if ($configFile->isReadable()) {
                $config = new JsonCompositionConfiguration();
                $config->fromFile($configFile);

                try {
                    $config->validate(new FileExistsValidator());
                    $output->writeln('<info>Successfully validated the config file!</info>');
                } catch (ValidatorException $exc) {
                    $output->writeln('<error>' . $exc->getMessage() . '</error>');
                }
            }
        }
    }

}
