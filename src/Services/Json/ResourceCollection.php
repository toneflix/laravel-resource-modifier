<?php

namespace ToneflixCode\ResourceModifier\Services\Json;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection as JsonResourceCollection;

class ResourceCollection extends JsonResourceCollection
{
    /**
     * Create a paginate-aware HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function preparePaginatedResponse($request)
    {
        if ($this->preserveAllQueryParameters) {
            $this->resource->appends($request->query());
        } elseif (! is_null($this->queryParameters)) {
            $this->resource->appends($this->queryParameters);
        }

        return (new PaginatedResourceResponse($this))->toResponse($request);
    }

    /**
     * Transform the resource into a JSON array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request)
    {
        if (config('resource-modifier.prefer_camel_casing', false) === true) {
            return $this->collection->map(function ($item) {
                return collect($item)
                    ->mapWithKeys(fn($value, $key) => [str($key)->camel()->toString() => $value])
                    ->toArray();
            })->all();
        }

        return $this->collection->map->toArray($request)->all();
    }
}
