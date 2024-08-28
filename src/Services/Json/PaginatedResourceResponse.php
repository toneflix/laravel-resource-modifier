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

        $default = [];

        if (in_array('links', config('resource-modifier.paginated_response_extra', ['meta', 'links']))) {
            $data = $this->paginationLinks($paginated);

            $links = collect(config('resource-modifier.paginated_response_links'))
                ->mapWithKeys(function ($value, $key) use ($data) {
                    return [$value => $data[$key] ?? null];
                });

            $default['links'] = $links;
        }

        if (in_array('meta', config('resource-modifier.paginated_response_extra', ['meta', 'links']))) {
            $data = $this->meta($paginated);

            $meta = collect(config('resource-modifier.paginated_response_meta'))
                ->mapWithKeys(function ($value, $key) use ($data) {
                    return [$value => $data[$key] ?? null];
                });

            $default['meta'] = $meta->toArray();
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
