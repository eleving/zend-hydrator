<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Hydrator\TestAsset;

use Iterator;

class ArrayObjectIterator implements Iterator
{

    private $var = [];

    public function __construct($array)
    {
        if (is_array($array)) {
            $this->var = $array;
        }
    }

    public function rewind()
    {
        reset($this->var);
    }

    public function current()
    {
        return current($this->var);
    }

    public function key()
    {
        return key($this->var);
    }

    public function next()
    {
        return next($this->var);
    }

    public function valid()
    {
        $key = key($this->var);
        $var = ($key !== null && $key !== false);

        return $var;
    }
}
