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

use Statika\Statika;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class AboutCommand extends Command
{
    protected function configure()
    {
        $this->setName('about')
                ->setDescription('Information about Statika');
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

        $output->writeln(sprintf('<headline><> %s %s</headline>', Statika::CLI_NAME, Statika::VERSION));
        $output->writeln(<<<EOT
   Created by Sven Scheffler
   Visit http://venyii.github.com/Statika/ for more information.
EOT
        );
    }

}
