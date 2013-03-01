<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <ven@cersei.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Test\File;

use Statika\File\File;
use Statika\File\FileSet;

class FileSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FileSet
     */
    protected $fileSet;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->fileSet = $this->getMock('Statika\Test\Mock\FilledFileSetMock', array('__construct'), array('css'));
    }

    /**
     * @covers Statika\File\FileSet::getFiles
     */
    public function testGetFiles()
    {
        $this->assertCount(4, $this->fileSet);

        foreach ($this->fileSet as $file) {
            $this->assertInstanceOf('Statika\File\File', $file);
        }
    }

    /**
     * @covers Statika\File\FileSet::getTargetName
     */
    public function testGetTargetName()
    {
        $this->fileSet->setTargetName('tn');
        $this->assertEquals('tn', $this->fileSet->getTargetName());
    }

    /**
     * @covers Statika\File\FileSet::setTargetName
     */
    public function testSetTargetName()
    {
        $this->fileSet->setTargetName('tn');
        $this->assertEquals('tn', $this->fileSet->getTargetName());
    }

    /**
     * @covers Statika\File\FileSet::getTargetBase
     */
    public function testGetTargetBase()
    {
        $this->fileSet->setTargetBase('tb');
        $this->assertEquals('tb', $this->fileSet->getTargetBase());
    }

    /**
     * @covers Statika\File\FileSet::setTargetBase
     */
    public function testSetTargetBase()
    {
        $this->fileSet->setTargetBase('tb');
        $this->assertEquals('tb', $this->fileSet->getTargetBase());
    }

    /**
     * @covers Statika\File\FileSet::getTargetSubDir
     */
    public function testGetTargetSubDir()
    {
        $this->fileSet->setTargetSubDir('tsb');
        $this->assertEquals('tsb', $this->fileSet->getTargetSubDir());
    }

    /**
     * @covers Statika\File\FileSet::setTargetSubDir
     */
    public function testSetTargetSubDir()
    {
        $this->fileSet->setTargetSubDir('tsb');
        $this->assertEquals('tsb', $this->fileSet->getTargetSubDir());
    }

    /**
     * @covers Statika\File\FileSet::getCompressorKey
     */
    public function testGetCompressorKey()
    {
        $this->fileSet->setCompressorKey('ck');
        $this->assertEquals('ck', $this->fileSet->getCompressorKey());
    }

    /**
     * @covers Statika\File\FileSet::setCompressorKey
     */
    public function testSetCompressorKey()
    {
        $this->fileSet->setCompressorKey('ck');
        $this->assertEquals('ck', $this->fileSet->getCompressorKey());
    }

    /**
     * @covers Statika\File\FileSet::count
     */
    public function testCount()
    {
        $this->assertCount(4, $this->fileSet);
    }

    /**
     * @covers Statika\File\FileSet::setFiles
     */
    public function testSetFiles()
    {
        $this->fileSet->setFiles(array());
        $this->assertEmpty($this->fileSet->getFiles());
    }

    /**
     * @covers Statika\File\FileSet::appendFile
     */
    public function testAppendFile()
    {
        $this->fileSet->appendFile(new File(__DIR__ . '/../../..//static/testing/css/file2.css'));
        $this->assertCount(5, $this->fileSet);
    }

    /**
     * @covers Statika\File\FileSet::assignTargets
     */
    public function testAssignTargets()
    {
        $this->fileSet->setTargetName('/some/path/somefile.css')->assignTargets();

        $this->assertEquals('/some/path/somefile.css', $this->fileSet->getTargetName());
        $this->assertEquals('/some/path', $this->fileSet->getTargetSubDir());
        $this->assertEquals('somefile.css', $this->fileSet->getTargetBase());
    }

}
