<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <ven@cersei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Configuration\Composition;

use Statika\Configuration\Configuration;
use Statika\Configuration\ValidatorInterface;
use Statika\File\Exception\FileNotFoundException;

/**
 * @author Sven Scheffler <ven@cersei.de>
 */
class CompositionValidator implements ValidatorInterface
{
    /**
     *
     * @param  Statika\Configuration\Composition\CompositionConfiguration $config
     * @return bool
     * @throws FileNotFoundException
     */
    public function validate(Configuration $config)
    {
        foreach ($config->getFileSets() as $fileSet) {
            /* @var $fileSet Statika\File\FileSet */

            foreach ($fileSet->getFiles() as $file) {
                /* @var $file Statika\File\File */

                if (!file_exists($file->getRealPath()) || !is_readable($file->getRealpath())) {
                    throw new FileNotFoundException($file->getRealPath());
                }
            }
        }

        return true;
    }

}
