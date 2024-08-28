<?php

namespace ToneflixCode\ResourceModifier;

class ResourceModifier
{
    /**
     * Call methods on the first dynamically caught parameter
     *
     * @return void
     */
    public function __call(string $name, array $params)
    {
        return $params[0]->{$name}(...array_slice($params, 1));
    }
}