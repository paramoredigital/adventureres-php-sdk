<?php

/**
 * Copyright 2016 AdventureRes
 *
 * @license GPL-3.0+
 */

namespace AdventureRes;

/**
 * Class AbstractAdventureResBase
 *
 * @package AdventureRes
 */
abstract class AbstractAdventureResBase
{
    public function __call($command, $arguments)
    {
        $class_methods = get_class_methods(__CLASS__);
        if (!in_array($command, $class_methods)) {
            throw new \BadMethodCallException(
              "Method $command not defined."
            );
        }
    }
}

/* End of AbstractAdventureResBase.php */