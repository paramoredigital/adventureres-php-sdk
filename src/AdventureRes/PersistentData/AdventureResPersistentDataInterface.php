<?php
/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes\PersistentData;

interface AdventureResPersistentDataInterface
{
    /**
     * Gets a variable from the PHP Session.
     *
     * @param $key
     * @param mixed $defaultValue If the key doesn't exist in the session, you can provide an optional default value.
     * @return mixed
     */
    public function get($key, $defaultValue = null);

    /**
     * Sets a variable to the PHP Session.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Deletes a variable from the PHP Session.
     *
     * @param $key
     */
    public function delete($key);
}

/* End of AdventureResPersistentDataInterface.php */