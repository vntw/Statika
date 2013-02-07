<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Test\Mock;

use Statika\File\File;
use Statika\File\FileSet;
use Symfony\Component\Finder\Finder;

class FilledFileSetMock extends FileSet {

    const TYPE_CSS = 'css';
    const TYPE_JS = 'js';

    private $type;

    public function __construct($type) {
        if (!in_array($type, array(self::TYPE_CSS, self::TYPE_JS))) {
            throw new \InvalidArgumentException(sprintf('Unknown type: %s', $type));
        }

        $this->type = $type;
        $this->getTestFiles();
    }

    private function getTestFiles() {
        $staticDir = __DIR__ . '/../../../static/testing/' . $this->type;

        $finder = new Finder();
        $finder->files()
                ->name('*.' . $this->type)
                ->notName('*min*')
                ->ignoreDotFiles(true)
                ->sortByName()
                ->in($staticDir);

        foreach ($finder as $file) {
            $this->appendFile(new File($file->getRealpath()));
        }
    }

}
