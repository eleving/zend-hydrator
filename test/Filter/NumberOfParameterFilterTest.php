<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Hydrator\Filter;

use PHPUnit\Framework\TestCase;
use Zend\Hydrator\Filter\NumberOfParameterFilter;

/**
 * Unit tests for {@see NumberOfParameterFilter}
 *
 * @covers \Zend\Hydrator\Filter\NumberOfParameterFilter
 */
class NumberOfParameterFilterTest extends TestCase
{
    /**
     * @group 6083
     */
    public function testArityZero()
    {
        $filter = new NumberOfParameterFilter();
        $this->assertTrue($filter->filter(__CLASS__ . '::methodWithNoParameters'));
        $this->assertFalse($filter->filter(__CLASS__ . '::methodWithOptionalParameters'));
    }

    /**
     * @group 6083
     */
    public function testArityOne()
    {
        $filter = new NumberOfParameterFilter(1);
        $this->assertFalse($filter->filter(__CLASS__ . '::methodWithNoParameters'));
        $this->assertTrue($filter->filter(__CLASS__ . '::methodWithOptionalParameters'));
    }

    /**
     * Test asset method
     */
    public function methodWithOptionalParameters($parameter = 'foo')
    {
    }

    /**
     * Test asset method
     */
    public function methodWithNoParameters()
    {
    }
}
