<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Configuration;

use Statika\Exception\FileNotFoundException;
use Statika\Configuration\Configuration;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class Validator {

	/**
	 *
	 * @var Symfony\Component\Console\Output\OutputInterface
	 */
	protected $output;

	/**
	 * CTOR
	 * 
	 * @param \Symfony\Component\Console\Output\OutputInterface $output
	 */
	public function __construct(OutputInterface $output) {
		$this->output = $output;
	}

	/**
	 * 
	 * @return bool
	 * @throws FileNotFoundException
	 */
	public function validate(Configuration $config) {
		foreach ($config->getFileSets() as $fileSet) {
			/* @var $fileSet Statika\File\FileSet */

			foreach ($fileSet->getFiles() as $file) {
				/* @var $file Statika\File\File */

				$this->output->writeln(
						sprintf('<comment>Validating file: %s</comment>', $file->getRealpath())
				);

				if (!file_exists($file->getRealPath())) {
					throw new FileNotFoundException($file->getRealPath());
				}
			}
		}

		return true;
	}

}
