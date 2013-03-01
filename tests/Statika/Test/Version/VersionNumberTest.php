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

use Statika\Version\VersionNumber;

class VersionNumberTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VersionNumber
     */
    protected $version;

    /**
     *
     * @var array
     */
    protected $versionNumberData = array(
        array(1),
        array(40),
        array(150),
        array(555),
        array(1000),
        array(1044),
        array(4000),
        array(11879),
        array(15000)
    );

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->version = new VersionNumber();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Statika\Version\VersionNumber::getKey
     */
    public function testGetKey()
    {
        $this->assertEquals('nr', $this->version->getKey());
    }

    /**
     *
     * @return array
     */
    public function getVersionNumbers()
    {
        return $this->versionNumberData;
    }

    /**
     * @covers Statika\Version\VersionNumber::getFormattedFileName
     * @dataProvider getVersionNumbers
     */
    public function testGetFormattedFileName($version)
    {
        $this->version->setFilePattern('file.min.{version|nr}.js')
                ->setVersion($version);

        $this->assertEquals(
                sprintf('file.min.%s.js', $this->version->formatPrettyVersion()), $this->version->getFormattedFileName()
        );
    }

    /**
     * @covers Statika\Version\VersionNumber::increaseVersion
     */
    public function testIncreaseVersion()
    {
        $this->version->setVersion(1)->increaseVersion();
        $this->assertEquals(2, $this->version->getVersion());
    }

    /**
     * @covers Statika\Version\VersionNumber::getRegexp
     */
    public function testGetRegexp()
    {
        $this->assertRegExp('/^' . $this->version->getRegexp() . '$/', '12345');
    }

    /**
     * @covers Statika\Version\VersionNumber::getVersionForFile
     */
    public function testGetLatestVersionForFile()
    {
        $staticDir = __DIR__ . '/../../../static/testing/css/min';
        $latestVersion = $this->version->getLatestVersion('yui.min.{version|nr}.css', $staticDir);

        $this->assertInstanceOf('\Statika\Version\VersionNumber', $latestVersion);
        $this->assertEquals(1, $latestVersion->getVersion());
    }

}
