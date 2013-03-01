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

use Statika\File\File;

/**
 * @author Sven Scheffler <ven@cersei.de>
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
        $config = @file_get_contents($configFile->getRealPath());

        $this->assignFromHash(json_decode($config, true));

        return $this;
    }

}
