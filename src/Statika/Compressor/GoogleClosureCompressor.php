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

use Statika\Compressor\BinaryCompressor;
use Statika\File\File;
use Statika\File\FileAggregator;
use Statika\Version\Version;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class GoogleClosureCompressor extends BinaryCompressor {

	/**
	 * CTOR
	 */
	public function __construct() {
		$this->name = 'closure';
	}

	/**
	 * 
	 * @param \Statika\Version\Version $version
	 * @return null
	 * @throws \InvalidArgumentException
	 */
	public function compress(Version $version) {
		$this->getManager()->getOutput()->writeln(
				sprintf('<info>Starting compression of output file \'%s\' (%d files)</info>', $this->manager->getConfiguration()->getName(), $this->aggregator->getFileSet()->count())
		);

		if (!$this->aggregator instanceof FileAggregator) {
			throw new \InvalidArgumentException('No aggregator provided!');
		}

		$fileSetAggregate = $this->aggregator->aggregate($this->manager->getOutput());

		$targetRawFile = $this->manager->getConfiguration()->getOutputDir() . DIRECTORY_SEPARATOR . '.tmp-' . $version->getFormattedFileName();
		$targetMinFile = $this->manager->getConfiguration()->getOutputDir() . DIRECTORY_SEPARATOR . $version->getFormattedFileName();

		if (false !== file_put_contents($targetRawFile, $fileSetAggregate)) {
			$outputRawFile = new File($targetRawFile);
			$this->bytesBefore = $outputRawFile->getSize();

			//  --compilation_level ADVANCED_OPTIMIZATIONS
			$cmd = sprintf('java -jar %s --js %s --js_output_file %s', $this->getBinaryPath(), $targetRawFile, $targetMinFile);
			exec(escapeshellcmd($cmd));
			unlink($targetRawFile);

			if (file_exists($targetMinFile)) {
				$outputMinFile = new File($targetMinFile);
				$this->bytesAfter = $outputMinFile->getSize();

				$this->manager->getOutput()->writeln(
						sprintf('<info>Successfully created minified version %s!</info>', $version->getFormattedFileName())
				);

				return;
			}
		}

		$this->manager->getOutput()->writeln('<error>Could not write tmp file!</error>');
	}

}