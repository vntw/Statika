<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <ven@cersei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika;

use Statika\Configuration\Application\ApplicationConfiguration;

/**
 * @author Sven Scheffler <ven@cersei.de>
 */
class Statika
{
    const VERSION = '1.0';
    const CLI_NAME = 'Statika CLI';

    /**
     *
     * @var \Statika\Configuration\Application\ApplicationConfiguration
     */
    protected static $config;

    /**
     *
     * @param \Statika\Configuration\Application\ApplicationConfiguration $config
     */
    public static function setConfig(ApplicationConfiguration $config)
    {
        self::$config = $config;
    }

    /**
     *
     * @return \Statika\Configuration\Application\ApplicationConfiguration
     */
    public static function getConfig()
    {
        return self::$config;
    }

}
