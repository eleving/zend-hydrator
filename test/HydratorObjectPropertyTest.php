<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Hdyrator;

use PHPUnit\Framework\TestCase;
use Zend\Hydrator\ObjectProperty;

class HydratorObjectPropertyTest extends TestCase
{
    protected function setUp(): void
    {
        $this->hydrator = new ObjectProperty();
    }

    public function testMultipleInvocationsWithDifferentFiltersFindsAllProperties()
    {
        $instance = (object) [];

        $instance->id         = 4;
        $instance->array      = [4, 3, 5, 6];
        $instance->object     = (object) [];
        $instance->object->id = 4;

        $this->hydrator->addFilter('values', function ($property) {
            return true;
        });
        $result = $this->hydrator->extract($instance);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($instance->id, $result['id']);
        $this->assertArrayHasKey('array', $result);
        $this->assertEquals($instance->array, $result['array']);
        $this->assertArrayHasKey('object', $result);
        $this->assertSame($instance->object, $result['object']);

        $this->hydrator->removeFilter('values');
        $this->hydrator->addFilter('complex', function ($property) {
            switch ($property) {
                case 'array':
                case 'object':
                    return false;
                default:
                    return true;
            }
        });
        $result = $this->hydrator->extract($instance);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($instance->id, $result['id']);
        $this->assertArrayNotHasKey('array', $result);
        $this->assertArrayNotHasKey('object', $result);
    }
}
