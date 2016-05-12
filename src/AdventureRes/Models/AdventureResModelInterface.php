<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\Models;

use AdventureRes\Exceptions\AdventureResModelException;

/**
 * Interface AdventureResModelInterface
 *
 * @package AdventureRes\Models
 */
interface AdventureResModelInterface
{
    /**
     * Populates a new model instance with a given set of attributes.
     *
     * @param array $attributes An array of attributes and values to populate into the model.
     * @return AbstractAdventureResModel
     */
    public static function populateModel($attributes);

    /**
     * Returns the list of the model's attribute names.
     *
     * @return array
     */
    public function getAttributeNames();

    /**
     * Returns an array of attributes and their assigned values of an instance of the model.
     *
     * @return array
     * @throws AdventureResModelException
     */
    public function getAttributes();

    /**
     * Returns the value for a specified attribute of an instance of the model.
     *
     * @param string $name
     * @return mixed
     * @throws AdventureResModelException
     */
    public function getAttribute($name);

    /**
     * Sets a value for a specified attribute on the instance of the model.
     *
     * @param string $name
     * @param mixed $value
     * @throws AdventureResModelException
     */
    public function setAttribute($name, $value);

    /**
     * Runs a validation check to see if the model instance is valid.
     *
     * @return bool
     * @throws AdventureResModelException
     */
    public function isValid();

    /**
     * Removes errors for all attributes or a single attribute.
     *
     * @param string|null $attributeName
     */
    public function clearErrors($attributeName = null);

    /**
     * Determines if the model instance contains errors.
     *
     * @return bool
     */
    public function hasErrors();

    /**
     * Returns an array of errors from the model instance.
     *
     * @return array|null
     */
    public function getErrors();

    /**
     * Returns all errors as a string.
     *
     * @return array|null
     */
    public function getErrorsAsString();
}

/* End of AdventureResModelInterface.php */