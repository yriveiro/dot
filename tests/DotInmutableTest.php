<?php
namespace Yriveiro\Dot\Tests;

use ArrayIterator;
use Yriveiro\Dot\Dot;
use Yriveiro\Dot\DotInterface;
use PHPUnit\Framework\TestCase;

class DotInmutableTest extends TestCase
{
    private $dot;

    public function setUp()
    {
        $this->dot = Dot::create([], true);
    }
    public function testCreateMutableInstance()
    {
        $this->assertInstanceOf(
            DotInterface::class,
            Dot::create(),
            'dot must be an instance of ' . DotInterface::class
        );
    }

    public function testCreateInmutableInstance()
    {
        $this->assertInstanceOf(
            DotInterface::class,
            Dot::create([], true),
            'dot must be an instance of ' . DotInterface::class
        );
    }


    public function testSearchEmptyPath()
    {
        $this->assertEquals(null, $this->dot->get(''));
    }

    public function testSearchNotExistingPath()
    {
        $this->assertNull($this->dot->get('foo'));
    }

    public function testSearchNotExistingPathWithDefault()
    {
        $this->assertEquals('bar', $this->dot->get('foo', 'bar'));
    }

    public function testGetExistingKeyOneLevel()
    {
        $dot = Dot::create(['foo' => 1]);

        $this->assertEquals(1, $dot->get('foo'));
    }

    public function testGetExistingKeyTwoLevels()
    {
        $dot = Dot::create(['foo' => ['bar' => 1]]);

        $this->assertEquals(1, $dot->get('foo.bar'));
    }

    public function testGetExistingKeyTreeLevelsThirdAsIndex()
    {
        $dot = Dot::create(['foo' => ['bar' => [1]]]);

        $this->assertEquals(1, $dot->get('foo.bar.0'));
    }

    public function testGetExistingKeyTreeLevelsThridAsArray()
    {
        $dot = Dot::create(['foo' => ['bar' => [1]]]);

        $this->assertEquals([1], $dot->get('foo.bar'));
    }

    public function testSetValue()
    {
        $this->dot = $this->dot->set('foo', 'bar');

        $this->assertEquals('bar', $this->dot->get('foo'));
    }

    public function testMutableSetValueWithMultiplePathLevel()
    {
        $this->dot = $this->dot->set('foo.bar', 1);

        $this->assertEquals(1, $this->dot->get('foo.bar'));
    }

    public function testInmutableSetValueWithMultiplePathLevel()
    {
        $dot = Dot::create([], true);
        $dot = $dot->set('foo.bar', 1);

        $this->assertEquals(1, $dot->get('foo.bar'));
    }

    public function testSetEmptyKey()
    {
        $this->assertFalse($this->dot->set('', false)->get(''));
    }

    public function testContainsKey()
    {
        $this->dot = $this->dot->set('foo', 'bar');

        $this->assertTrue($this->dot->contains('foo'));
    }

    public function testNotContainsKey()
    {
        $this->dot->set('foo', 'bar');

        $this->assertFalse($this->dot->contains('not-found'));
    }

    public function testContainsWithEmptyKey()
    {
        $this->dot = $this->dot->set('', 'foo');
        $this->assertTrue($this->dot->contains(''));
    }

    public function testInmutableSet()
    {
        $dot = Dot::create([], true);
        $inmutableDot = $dot->set('foo', 'bar');

        $this->assertFalse($inmutableDot === $dot);
    }

    public function testLoadJson()
    {
        $dot = Dot::loadJson('{"foo":"bar"}');

        $this->assertEquals('bar', $dot->get('foo'));
    }

    public function testToJsonNoPathDefined()
    {
        $dot = Dot::loadJson('{"foo":"bar"}');

        $this->assertEquals('{"foo":"bar"}', $dot->toJson());
    }

    public function testToJsonPathDefined()
    {
        $dot = Dot::loadJson('{"foo":"bar","foo2":{"key":"value"}}');

        $this->assertEquals('{"key":"value"}', $dot->toJson('foo2'));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedMessage json_decode returns: Syntax error
     */
    public function testLoadJsonWithInvalidJson()
    {
        $dot = Dot::loadJson('"foo":"bar"');
    }

    public function testJsonSerialize()
    {
        $jsonString = '{"foo":"bar"}';
        $this->dot = $this->dot->set('foo', 'bar');

        $this->assertEquals($jsonString, json_encode($this->dot));
    }

    public function testArrayIteratorInterface()
    {
        $this->assertInstanceOf(ArrayIterator::class, $this->dot->getIterator());
    }

    public function testReset()
    {
        $dot = Dot::loadJson('{"foo":"bar","foo2":{"key":"value"}}', true);
        $dot = $dot->reset();
        $this->assertNull($dot->get('foo2.key'));
    }

    public function testDeleteKey()
    {
        $dot = Dot::loadJson('{"foo":"bar","foo2":{"key":"value"}}', true);

        $dot = $dot->delete('foo2.key');

        $this->assertEquals([], $dot->get('foo2'));
        $this->assertEquals('bar', $dot->get('foo'));
    }
}
