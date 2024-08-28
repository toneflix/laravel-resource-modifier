<?php

return [
    /*
    |---------------------------------------------------------------------------------
    | Paginated Response Extra
    |---------------------------------------------------------------------------------
    |
    | These configuration options determine what extra metadata will be
    | appended to your API response.
    |
    | Supported options: "meta", "links"
    |
    */

    'paginated_response_extra' => ['meta', 'links'],

    /*
    |---------------------------------------------------------------------------------
    | Paginated Response Meta
    |---------------------------------------------------------------------------------
    |
    | These configuration options determine what metadata will be
    | available in the [meta] array and how they will be presented.
    | The values will be used as the keys in the array.
    |
    | Supported options:
    | "to", "from", "links", "path", "total", "per_page", "last_page", "current_page"
    |
    */

    'paginated_response_meta' => [
        'to' => 'to',
        'from' => 'from',
        'links' => 'links',
        'path' => 'path',
        'total' => 'total',
        'per_page' => 'per_page',
        'last_page' => 'last_page',
        'current_page' => 'current_page',
    ],

    /*
    |---------------------------------------------------------------------------------
    | Paginated Response Links
    |---------------------------------------------------------------------------------
    |
    | These configuration options determine what links will be
    | available in the [links] array and how they will be presented.
    | The values will be used as the keys in the array.
    |
    | Supported options:
    | "first", "last", "prev", "next"
    |
    */

    'paginated_response_links' => [
        'first' => 'first',
        'last' => 'last',
        'prev' => 'prev',
        'next' => 'next',
    ]
];