<?php

/*
 * This file is part of Statika.
 *
 * (c) Sven Scheffler <schefflor@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Statika\Test\File;

use Statika\File\FileAggregator;

class FileAggregatorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var FileAggregator
     */
    protected $aggregator;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->aggregator = new FileAggregator();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionWithNoFileset() {
        $this->aggregator->aggregate();
    }

    /**
     * @covers Statika\File\FileAggregator::aggregate
     */
    public function testAggregate() {
        $fileSet = new \Statika\Test\Mock\FilledFileSetMock('css');
        $aggregated = $this->aggregator->setFileSet($fileSet)->aggregate();
        $this->assertEquals('file1file2file4file3', $aggregated);
    }

}
