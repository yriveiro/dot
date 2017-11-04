<?php
namespace Yriveiro\Dot\Tests;

use Yriveiro\Dot\Dot;
use PHPUnit\Framework\TestCase;

class DotTest extends TestCase
{
    public function setUp()
    {
        $this->dot = new Dot();
    }

    public function testCreateInstance()
    {
        $this->assertInstanceOf(Dot::class, $this->dot, 'dot must be an instance of ' . Dot::class);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage path can't be empty
     */
    public function testSearchEmptyPath()
    {
        $this->dot->get('');
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
        $dot = new Dot(['foo' => 1]);

        $this->assertEquals(1, $dot->get('foo'));
    }

    public function testGetExistingKeyTwoLevels()
    {
        $dot = new Dot(['foo' => ['bar' => 1]]);

        $this->assertEquals(1, $dot->get('foo.bar'));
    }

    public function testGetExistingKeyTreeLevelsThirdAsIndex()
    {
        $dot = new Dot(['foo' => ['bar' => [1]]]);

        $this->assertEquals(1, $dot->get('foo.bar.0'));
    }

    public function testGetExistingKeyTreeLevelsThridAsArray()
    {
        $dot = new Dot(['foo' => ['bar' => [1]]]);

        $this->assertEquals([1], $dot->get('foo.bar'));
    }

    public function testSetValue()
    {
        $this->dot->set('foo', 'bar');

        $this->assertEquals('bar', $this->dot->get('foo'));
    }

    public function testMutableSetValueWithMultiplePathLevel()
    {
        $this->dot->set('foo.bar', 1);

        $this->assertEquals(1, $this->dot->get('foo.bar'));
    }

    public function testInmutableSetValueWithMultiplePathLevel()
    {
        $dot = new Dot([], true);

        $dot = $dot->set('foo.bar', 1);

        $this->assertEquals(1, $dot->set('foo.bar', 1)->get('foo.bar'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage path can't be empty
     */
    public function testSetEmptyKey()
    {
        $this->dot->set('', false);
    }

    public function testContainsKey()
    {
        $this->dot->set('foo', 'bar');

        $this->assertTrue($this->dot->contains('foo'));
    }

    public function testNotContainsKey()
    {
        $this->dot->set('foo', 'bar');

        $this->assertFalse($this->dot->contains('not-found'));
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedMessage path can't be empty
     */
    public function testContainsWithEmptyKey()
    {
        $this->dot->contains('');
    }

    public function testMutableSet()
    {
        $that = $this->dot->set('foo', 'bar');

        $this->assertTrue($that === $this->dot);
    }

    public function testInmutableSet()
    {
        $dot = new Dot([], true);
        $inmutableDot = $dot->set('foo', 'bar');

        $this->assertFalse($inmutableDot === $dot);
    }

    public function testFromJson()
    {
        $dot = Dot::fromJson('{"foo":"bar"}');

        $this->assertEquals('bar', $dot->get('foo'));
    }

    public function testToJsonNoPathDefined()
    {
        $dot = Dot::fromJson('{"foo":"bar"}');

        $this->assertEquals('{"foo":"bar"}', $dot->toJson());
    }

    public function testToJsonPathDefined()
    {
        $dot = Dot::fromJson('{"foo":"bar","foo2":{"key":"value"}}');

        $this->assertEquals('{"key":"value"}', $dot->toJson('foo2'));
    }

    /**
     * @expectedException RuntimeException
     * @expectedMessage json_decode returns: Syntax error
     */
    public function testFromJsonWithInvalidJson()
    {
        $dot = Dot::fromJson('"foo":"bar"');
    }

    public function testJsonSerialize()
    {
        $jsonString = '{"foo":"bar"}';
        $this->dot->set('foo', 'bar');

        $this->assertEquals($jsonString, json_encode($this->dot));
    }
}
