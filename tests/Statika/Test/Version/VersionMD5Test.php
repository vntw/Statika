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

use Statika\Version\VersionMD5;

class VersionMD5Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VersionMD5
     */
    protected $version;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->version = new VersionMD5();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Statika\Version\VersionMD5::getKey
     */
    public function testGetKey()
    {
        $this->assertEquals('md5', $this->version->getKey());
    }

    /**
     * @covers Statika\Version\VersionMD5::increaseVersion
     */
    public function testIncreaseVersion()
    {
        $oldVersion = $this->version->getVersion();
        $this->version->increaseVersion();
        $this->assertNotEquals($oldVersion, $this->version->getVersion());
    }

    /**
     * @covers Statika\Version\VersionMD5::getRegexp
     */
    public function testGetRegexp()
    {
        $this->assertRegExp('/^' . $this->version->getRegexp() . '$/', '42de4ba22e59b636b13adec4fa7f7abd');
    }

    /**
     * @covers Statika\Version\VersionMD5::getVersionForFile
     */
    public function testGetVersionForFile()
    {
        // No versioning for VersionMD5 needed -> randomly created
    }

}
