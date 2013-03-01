<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <ven@cersei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Test\Mock;

use Statika\File\File;
use Statika\File\FileSet;
use Symfony\Component\Finder\Finder;

class FilledFileSetMock extends FileSet
{
    const TYPE_CSS = 'css';
    const TYPE_JS = 'js';

    /**
     * self::TYPE_CSS, self::TYPE_JS
     *
     * @var string
     */
    protected $type;

    /**
     *
     * @param  string                               $type
     * @return \Statika\Test\Mock\FilledFileSetMock
     * @throws \InvalidArgumentException
     */
    public function __construct($type)
    {
        if (!in_array($type, array(self::TYPE_CSS, self::TYPE_JS))) {
            throw new \InvalidArgumentException(sprintf('Unknown type: %s', $type));
        }

        $this->type = $type;
        $this->collectTestFiles();
    }

    /**
     * Collect the test files with the specified type
     */
    public function collectTestFiles()
    {
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
