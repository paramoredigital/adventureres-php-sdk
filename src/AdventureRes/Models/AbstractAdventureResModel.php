<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models;

use AdventureRes\AbstractAdventureResBase;
use AdventureRes\Exceptions\AdventureResModelException;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

/**
 * Class AbstractAdventureResModel
 *
 * @package AdventureRes\Models
 */
abstract class AbstractAdventureResModel extends AbstractAdventureResBase implements AdventureResModelInterface
{
    /**
     * @var array
     */
    private $attributes;
    /**
     * @var array
     */
    private $errors = [];

    /**
     * AbstractAdventureResModel constructor.
     *
     * @param array|null $attributes
     */
    public function __construct($attributes = null)
    {
        if (is_array($attributes) || $attributes instanceof \Traversable) {
            foreach ($attributes as $attribute => $value) {
                if ($attribute === 'Result') {
                    continue;
                }

                $this->setAttribute($attribute, $value);
            }
        }
    }

    /**
     * PHP magic method to treat attributes from defineAttributes as properties.
     *
     * @param $name
     * @return mixed
     * @throws AdventureResModelException
     */
    function __get($name)
    {
        return $this->getAttribute($name);
    }

    /**
     * PHP magic method to treat attributes from defineAttributes as properties.
     *
     * @param $name
     * @param $value
     * @throws AdventureResModelException
     */
    function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    /**
     * PHP magic method to treat attributes from defineAttributes as properties.
     *
     * @param $name
     * @return bool
     */
    function __isset($name)
    {
        return (in_array($name, $this->getAttributeNames()));
    }

    /**
     * @inheritdoc
     */
    public static function populateModel($attributes)
    {
        $class = get_called_class();

        return new $class($attributes);
    }

    /**
     * @inheritdoc
     */
    public function getAttributeNames()
    {
        return array_keys($this->defineAttributes());
    }

    /**
     * @inheritdoc
     */
    public function getAttributes()
    {
        $attributes = [];

        foreach ($this->getAttributeNames() as $attributeName) {
            $attributes[$attributeName] = $this->getAttribute($attributeName);
        }

        return $attributes;
    }

    /**
     * @inheritdoc
     */
    public function getAttribute($name)
    {
        if (in_array($name, $this->getAttributeNames())) {
            return isset($this->attributes[$name]) ? $this->attributes[$name] : null;

        } else {
            throw new AdventureResModelException("Property {$name} does not exist.");
        }
    }

    /**
     * @inheritdoc
     */
    public function setAttribute($name, $value)
    {
        if (in_array($name, $this->getAttributeNames())) {
            $this->attributes[$name] = $value;

        } else {
            throw new AdventureResModelException("Property {$name} does not exist and cannot be set.");
        }
    }

    /**
     * @inheritdoc
     */
    public function isValid()
    {
        $this->clearErrors();

        /**
         * @var string $attribute
         * @var Validator $validator
         */
        foreach ($this->defineAttributes() as $attribute => $validator) {
            try {
                $validator->assert($this->getAttribute($attribute));

            } catch (NestedValidationException $exception) {
                $this->errors[$attribute] = $exception->getMessages();
            }
        }

        return (!$this->hasErrors());
    }

    /**
     * @inheritdoc
     */
    public function clearErrors($attributeName = null)
    {
        if ($attributeName === null) {
            $this->errors = [];

        } else {
            unset($this->errors[$attributeName]);
        }
    }

    /**
     * @inheritdoc
     */
    public function hasErrors()
    {
        return (count($this->errors) > 0);
    }

    /**
     * @inheritdoc
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @inheritdoc
     */
    public function getErrorsAsString()
    {
        $errorString = '';

        foreach ($this->errors as $property => $errors) {
            foreach ($errors as $error) {
                $errorString .= "({$property}): {$error}. ";
            }
        }

        return $errorString;
    }

    /**
     * Defines this model's attributes.
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return [];
    }
}

/* End of AbstractAdventureResModel.php */