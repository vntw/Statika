<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <ven@cersei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Test\Version;

use Statika\Version\Version;

class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Statika\Version\Version::parseVersionHandler
     * @expectedException \OutOfBoundsException
     */
    public function testParseVersionHandler()
    {
        Version::parseVersionHandler('SomethingThatDoesNotExist');
    }

}
