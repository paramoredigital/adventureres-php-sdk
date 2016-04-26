<?php

namespace AdventureRes\Tests\Models;

use \AdventureRes\Models\AbstractAdventureResModel;
use \Respect\Validation\Validator;

class MyTestModel extends AbstractAdventureResModel
{
    protected function defineAttributes()
    {
        return [
          'foo' => Validator::numeric(),
          'bar' => Validator::boolType(),
          'baz' => Validator::optional(Validator::alpha())
        ];
    }
}

class AbstractAdventureResModelTest extends \PHPUnit_Framework_TestCase
{
    public function testCanGetAttributeNames()
    {
        $model = new MyTestModel();
        $names = $model->getAttributeNames();

        $this->assertNotEmpty($names);
        $this->assertEquals(3, count($names));
        $this->assertEquals('foo', $names[0]);
        $this->assertEquals('bar', $names[1]);
    }

    public function testCanPopulateModelWithAttributes()
    {
        $attributes = ['foo' => 123, 'bar' => true];
        $model      = MyTestModel::populateModel($attributes);

        $this->assertEquals(123, $model->foo);
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResModelException
     */
    public function testPopulatingNonexistentAttributeThrowsException()
    {
        $attributes = ['scud' => 'baz'];
        MyTestModel::populateModel($attributes);
    }

    public function testCanSetAttributeByMethod()
    {
        $model = new MyTestModel();

        $model->setAttribute('foo', 123);

        $this->assertEquals(123, $model->getAttribute('foo'));
    }

    public function testCanSetAttributeByName()
    {
        $model = new MyTestModel();

        $model->foo = 123;

        $this->assertEquals(123, $model->foo);
    }

    public function testOptionalAttributesNotRequired()
    {
        $model = MyTestModel::populateModel(['foo' => 123, 'bar' => true]);

        $this->assertTrue($model->isValid());
    }

    public function testOptionalAttributesValidate()
    {
        $model = MyTestModel::populateModel(['foo' => 123, 'bar' => true, 'baz' => '456']);

        $this->assertFalse($model->isValid());
    }

    public function testGetAttributes()
    {
        $model      = MyTestModel::populateModel(['foo' => 123, 'bar' => true]);
        $attributes = $model->getAttributes();

        $this->assertNotEmpty($attributes);
        $this->assertEquals(123, $attributes['foo']);
        $this->assertTrue($attributes['bar']);
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResModelException
     */
    public function testGetNonexistentAttributeByNameThrowsException()
    {
        $model = MyTestModel::populateModel(['foo' => 123, 'bar' => true]);

        $model->scud;
    }

    /**
     * @expectedException \AdventureRes\Exceptions\AdventureResModelException
     */
    public function testGetNonexistentAttributeByMethodThrowsException()
    {
        $model = MyTestModel::populateModel(['foo' => 123, 'bar' => true]);

        $model->getAttribute('scud');
    }

    public function testIsValid()
    {
        $model = MyTestModel::populateModel(['foo' => 123, 'bar' => true]);

        $this->assertTrue($model->isValid());

        $model->setAttribute('foo', 'abc');
        $model->setAttribute('bar', 'scud');

        $this->assertFalse($model->isValid());
    }

    public function testIsValidClearsErrors()
    {
        $model = MyTestModel::populateModel(['foo' => 123]);

        $model->isValid();

        $this->assertTrue($model->hasErrors());

        $model->bar = true;

        $model->isValid();

        $this->assertFalse($model->hasErrors());
    }

    public function testCanClearErrorsForAttribute()
    {
        $model = MyTestModel::populateModel(['foo' => 'abc', 'bar' => 'baz']);

        $model->isValid();

        $this->assertArrayHasKey('foo', $model->getErrors());

        $model->clearErrors('foo');

        $this->assertTrue($model->hasErrors());
        $this->assertArrayNotHasKey('foo', $model->getErrors());
    }

    public function testCanGetErrors()
    {
        $model = MyTestModel::populateModel(['foo' => 'abc', 'bar' => 'scud']);
        $model->isValid();

        $this->assertNotEmpty($model->getErrors());
        $this->assertEquals(2, count($model->getErrors()));
    }

}
