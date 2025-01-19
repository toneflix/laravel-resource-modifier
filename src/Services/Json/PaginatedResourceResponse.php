<?php

namespace ToneflixCode\ResourceModifier\Services\Json;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as JsonPaginatedResourceResponse;

class PaginatedResourceResponse extends JsonPaginatedResourceResponse
{
    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        $paginated = $this->resource->resource->toArray();

        $camelize = config('resource-modifier.prefer_camel_casing', false) === true;
        $response_extra = config('resource-modifier.paginated_response_extra', ['meta', 'links']);

        $default = [];

        if (in_array('links', $response_extra) || isset($response_extra['links'])) {
            $data = $this->paginationLinks($paginated);

            $links = collect(config('resource-modifier.paginated_response_links'))
                ->mapWithKeys(function ($value, $key) use ($data) {
                    return [$value => $data[$key] ?? null];
                });

            if (isset($response_extra['links'])) {
                $default[$response_extra['links']] = $links;
            } else {
                $default['links'] = $links;
            }
        }

        if (in_array('meta', $response_extra) || isset($response_extra['meta'])) {
            $data = $this->meta($paginated);

            $meta = collect(config('resource-modifier.paginated_response_meta'))
                ->mapWithKeys(function ($value, $key) use ($data, $camelize) {
                    return [str($value)->when($camelize, fn($v) => $v->camel())->toString() => $data[$key] ?? null];
                });

            if (isset($response_extra['meta'])) {
                $default[$response_extra['meta']] = $meta->toArray();
            } else {
                $default['meta'] = $meta->toArray();
            }
        }

        if (
            method_exists($this->resource, 'paginationInformation') ||
            $this->resource->hasMacro('paginationInformation')
        ) {
            return $this->resource->paginationInformation($request, $paginated, $default);
        }

        return $default;
    }
}
