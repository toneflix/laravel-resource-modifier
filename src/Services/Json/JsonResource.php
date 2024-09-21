<?php

namespace ToneflixCode\ResourceModifier\Services\Json;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource as IlluminateJsonResource;
use JsonSerializable;

class JsonResource extends IlluminateJsonResource
{
    /**
     * Resolve the resource to an array.
     *
     * @param  \Illuminate\Http\Request|null  $request
     * @return array
     */
    public function resolve($request = null)
    {
        $data = $this->toArray(
            $request ?: Container::getInstance()->make('request')
        );

        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        } elseif ($data instanceof JsonSerializable) {
            $data = $data->jsonSerialize();
        }

        if (config('resource-modifier.prefer_camel_casing', false) === true) {
            return collect($this->filter((array) $data))
                ->mapWithKeys(fn($value, $key) => [str($key)->camel()->toString() => $value])
                ->toArray();
        }

        return $this->filter((array) $data);
    }
}
