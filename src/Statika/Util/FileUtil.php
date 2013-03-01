<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Util;

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
class FileUtil
{
    /**
     *
     * @param  int    $bytes
     * @return string
     */
    public static function formatFilesize($bytes)
    {
        if (is_int($bytes) && $bytes > 0) {
            $unit = intval(log($bytes, 1024));
            $units = array('B', 'KB', 'MB', 'GB');

            if (array_key_exists($unit, $units) === true) {
                return sprintf('%d%s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }

        return $bytes;
    }

}
