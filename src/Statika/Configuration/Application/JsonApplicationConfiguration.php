<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <ven@cersei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Configuration\Application;

use \Statika\File\File;

/**
 * @author Sven Scheffler <ven@cersei.de>
 */
class JsonApplicationConfiguration extends ApplicationConfiguration
{
    /**
     *
     * @param  \Statika\File\File                                              $configFile
     * @return \Statika\Configuration\Application\JsonApplicationConfiguration
     */
    public function fromFile(File $configFile)
    {
        $this->assignFromHash(json_decode(file_get_contents($configFile->getRealPath()), true));

        return $this;
    }

}
