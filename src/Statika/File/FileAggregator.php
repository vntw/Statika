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
class FileAggregator extends Aggregator {

	/**
	 *
	 * @var \Statika\File\FileSet
	 */
	protected $fileSet;

	/**
	 * 
	 * @return \Statika\File\FileSet
	 */
	public function getFileSet() {
		return $this->fileSet;
	}

	/**
	 * CTOR
	 * 
	 * @param \Statika\File\FileSet $fileSet
	 */
	public function __construct(FileSet $fileSet) {
		$this->fileSet = $fileSet;
	}

	/**
	 * 
	 * @param \Symfony\Component\Console\Output\OutputInterface $output
	 * @return string
	 * @throws \InvalidArgumentException
	 */
	public function aggregate(OutputInterface $output = null) {
		if (!$this->fileSet instanceof FileSet) {
			throw new \InvalidArgumentException('No fileset provided!');
		}

		$aggregator = '';

		foreach ($this->fileSet->getFiles() as $file) {
			if (null !== $output) {
				$output->writeln(
						sprintf('<comment>Reading file %s</comment>', $file->getRealPath())
				);
			}
			$aggregator .= file_get_contents($file->getRealPath());
		}

		return $aggregator;
	}

}