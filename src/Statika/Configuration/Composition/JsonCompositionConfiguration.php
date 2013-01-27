<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Configuration\Composition;

use Statika\File\File;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class JsonCompositionConfiguration extends CompositionConfiguration
{
    /**
     *
     * @param  \Statika\File\File                                   $configFile
     * @return \Statika\Configuration\Composition\JsonConfiguration
     */
    public function fromFile(File $configFile)
    {
        $this->assignFromHash(
                json_decode(file_get_contents($configFile->getRealPath()), true)
        );

        return $this;
    }

}
