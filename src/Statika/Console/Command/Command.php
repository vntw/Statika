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

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
abstract class Command extends BaseCommand
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->injectAdditionalStyles($output);
    }

    /**
     * Add additional console output styles
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    private function injectAdditionalStyles(OutputInterface $output)
    {
        $output->getFormatter()->setStyle(
                'headline', new OutputFormatterStyle('green', null, array('bold'))
        );
        $output->getFormatter()->setStyle(
                'result', new OutputFormatterStyle('white', null, array('bold'))
        );
        $output->getFormatter()->setStyle(
                'item', new OutputFormatterStyle('white')
        );
    }

}
