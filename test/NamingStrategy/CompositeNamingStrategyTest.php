<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Hydrator\NamingStrategy;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Zend\Hydrator\NamingStrategy\CompositeNamingStrategy;
use Zend\Hydrator\NamingStrategy\NamingStrategyInterface;

/**
 * Tests for {@see CompositeNamingStrategy}
 *
 * @covers \Zend\Hydrator\NamingStrategy\CompositeNamingStrategy
 */
class CompositeNamingStrategyTest extends TestCase
{
    public function testGetSameNameWhenNoNamingStrategyExistsForTheName()
    {
        $compositeNamingStrategy = new CompositeNamingStrategy([
            'foo' => $this->createMock('Zend\Hydrator\NamingStrategy\NamingStrategyInterface')
        ]);

        $this->assertEquals('bar', $compositeNamingStrategy->hydrate('bar'));
        $this->assertEquals('bar', $compositeNamingStrategy->extract('bar'));
    }

    public function testUseDefaultNamingStrategy()
    {
        /* @var $defaultNamingStrategy NamingStrategyInterface|PHPUnit_Framework_MockObject_MockObject*/
        $defaultNamingStrategy = $this->createMock('Zend\Hydrator\NamingStrategy\NamingStrategyInterface');
        $defaultNamingStrategy->expects($this->at(0))
            ->method('hydrate')
            ->with('foo')
            ->will($this->returnValue('Foo'));
        $defaultNamingStrategy->expects($this->at(1))
            ->method('extract')
            ->with('Foo')
            ->will($this->returnValue('foo'));

        $compositeNamingStrategy = new CompositeNamingStrategy(
            ['bar' => $this->createMock('Zend\Hydrator\NamingStrategy\NamingStrategyInterface')],
            $defaultNamingStrategy
        );
        $this->assertEquals('Foo', $compositeNamingStrategy->hydrate('foo'));
        $this->assertEquals('foo', $compositeNamingStrategy->extract('Foo'));
    }

    public function testHydrate()
    {
        $fooNamingStrategy = $this->createMock('Zend\Hydrator\NamingStrategy\NamingStrategyInterface');
        $fooNamingStrategy->expects($this->once())
            ->method('hydrate')
            ->with('foo')
            ->will($this->returnValue('FOO'));
        $compositeNamingStrategy = new CompositeNamingStrategy(['foo' => $fooNamingStrategy]);
        $this->assertEquals('FOO', $compositeNamingStrategy->hydrate('foo'));
    }

    public function testExtract()
    {
        $fooNamingStrategy = $this->createMock('Zend\Hydrator\NamingStrategy\NamingStrategyInterface');
        $fooNamingStrategy->expects($this->once())
            ->method('extract')
            ->with('FOO')
            ->will($this->returnValue('foo'));
        $compositeNamingStrategy = new CompositeNamingStrategy(['FOO' => $fooNamingStrategy]);
        $this->assertEquals('foo', $compositeNamingStrategy->extract('FOO'));
    }
}
