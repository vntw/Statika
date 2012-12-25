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

/**
 * @author Sven Scheffler <schefflor@gmail.com>
 */
interface ValidatorInterface
{
    public function getError();

    public function validate(Configuration $config);
}
