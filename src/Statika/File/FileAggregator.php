<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\File;

use Statika\File\FileSet;
use Statika\File\Aggregator;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class FileAggregator implements Aggregator
{
    /**
     *
     * @var \Statika\File\FileSet
     */
    protected $fileSet;

    /**
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     *
     * @param  \Statika\File\FileSet        $fileSet
     * @return \Statika\File\FileAggregator
     */
    public function setFileSet(FileSet $fileSet)
    {
        $this->fileSet = $fileSet;

        return $this;
    }

    /**
     *
     * @return \Statika\File\FileSet
     */
    public function getFileSet()
    {
        return $this->fileSet;
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
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return \Statika\File\FileAggregator
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function aggregate()
    {
        if (!$this->fileSet instanceof FileSet) {
            throw new \InvalidArgumentException('No fileset provided!');
        }

        $aggregatedContent = '';

        foreach ($this->fileSet->getFiles() as $file) {
            if (null !== $this->output) {
                $this->output->writeln(
                        sprintf('<item>- Reading file %s</item>', $file->getRealPath())
                );
            }

            $aggregatedContent .= file_get_contents($file->getRealPath());
        }

        return $aggregatedContent;
    }

}
