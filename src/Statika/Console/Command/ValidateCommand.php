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
use Statika\Console\Command\Command;
use Statika\Configuration\Composition\JsonCompositionConfiguration;
use Statika\Configuration\Composition\CompositionValidator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class ValidateCommand extends Command
{
    protected function configure()
    {
        $this->setName('validate')
                ->setDescription('Validates a given composition config')
                ->addArgument('config', InputArgument::REQUIRED, 'The config file to validate');
    }

    /**
     *
     * @param \Symfony\Component\Console\Input\InputInterface   $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
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
                $configuration = new JsonCompositionConfiguration();
                break;
            default:
                throw new \InvalidArgumentException('No handler for config type ' . $configFile->getExtension() . ' available!');
        }

        $configuration->fromFile($configFile);
        $validator = new CompositionValidator();

        $fileCount = 0;
        foreach ($configuration->getFileSets() as $fileSet) {
            $fileCount += $fileSet->count();
        }

        $output->writeln('<headline><> Validating config file @ ' . $config . '...</headline>');
        $output->writeln(sprintf('<info>   (%d filesets, %d files)</info>', count($configuration->getFileSets()), $fileCount));

        try {
            $validator->validate($configuration);
            $output->writeln(
                    '<result><> Successfully validated the config file! All files are readable and exist.</result>'
            );
        } catch (\Exception $exc) {
            $output->writeln('<error>' . $exc->getMessage() . '</error>');
        }
    }

}
