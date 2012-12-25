<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Configuration\Validator;

use Statika\Configuration\Configuration;
use Statika\File\Exception\FileNotFoundException;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class FileExistsValidator implements ValidatorInterface
{
    /**
     *
     * @var string
     */
    protected $error;

    /**
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     *
     * @param  \Statika\Configuration\Configuration $config
     * @return bool
     * @throws FileNotFoundException
     */
    public function validate(Configuration $config)
    {
        foreach ($config->getFileSets() as $fileSet) {
            /* @var $fileSet Statika\File\FileSet */

            foreach ($fileSet->getFiles() as $file) {
                /* @var $file Statika\File\File */

                if (!file_exists($file->getRealPath())) {
                    throw new FileNotFoundException($file->getRealPath());
                }
            }
        }

        return true;
    }

}
