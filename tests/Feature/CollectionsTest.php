<?php

use Illuminate\Support\Facades\Route;
use ToneflixCode\ResourceModifier\Tests\App\Http\Resources\UserCollection;
use ToneflixCode\ResourceModifier\Tests\Models\User;

test('can load collection', function () {

    User::factory(10)->create();

    Route::get('test/users', function () {
        return new UserCollection(User::paginate(6));
    });

    $response = $this->get('/test/users');

    $response->assertOk();

    $this->assertArrayHasKey('links', $response->collect());
    $this->assertArrayHasKey('meta', $response->collect());
    $this->assertArrayHasKey('data', $response->collect());
});

test('can load collection with meta as configured', function () {
    config([
        'resource-modifier.paginated_response_meta' => [
            'to' => 'to',
            'from' => 'from',
            'links' => 'links',
            'path' => 'path',
            'total' => 'total',
            'per_page' => 'perPage',
            'last_page' => 'lastPage',
            'current_page' => 'currentPage',
        ],
        'resource-modifier.paginated_response_links' => [],
    ]);

    User::factory(10)->create();

    Route::get('test/users', function () {
        return new UserCollection(User::paginate(6));
    });

    $response = $this->get('/test/users');

    $response->assertOk();

    $this->assertArrayHasKey('currentPage', $response->collect('meta'));
    $this->assertArrayHasKey('lastPage', $response->collect('meta'));
    $this->assertArrayHasKey('perPage', $response->collect('meta'));
});

test('can load collection with links as configured', function () {
    config([
        'resource-modifier.paginated_response_links' => [
            'first' => 'firstItem',
            'last' => 'lastItem',
            'prev' => 'previousItem',
            'next' => 'nextItem',
        ],
        'resource-modifier.paginated_response_meta' => [],
    ]);

    User::factory(10)->create();

    Route::get('test/users', function () {
        return new UserCollection(User::paginate(6));
    });

    $response = $this->get('/test/users');

    $response->assertOk();

    $this->assertArrayHasKey('firstItem', $response->collect('links'));
    $this->assertArrayHasKey('lastItem', $response->collect('links'));
    $this->assertArrayHasKey('nextItem', $response->collect('links'));
});

test('can load collection without links as configured', function () {
    config([
        'resource-modifier.paginated_response_extra' => ['meta'],
    ]);

    User::factory(10)->create();

    Route::get('test/users', function () {
        return new UserCollection(User::paginate(6));
    });

    $response = $this->get('/test/users');

    $response->assertOk();

    $this->assertArrayNotHasKey('links', $response->collect());
});

test('can load collection without meta as configured', function () {
    config([
        'resource-modifier.paginated_response_extra' => ['links'],
    ]);

    User::factory(10)->create();

    Route::get('test/users', function () {
        return new UserCollection(User::paginate(6));
    });

    $response = $this->get('/test/users');

    $response->assertOk();

    $this->assertArrayNotHasKey('meta', $response->collect());
});

test('can load collection without meta and links as configured', function () {
    config([
        'resource-modifier.paginated_response_extra' => [],
    ]);

    User::factory(10)->create();

    Route::get('test/users', function () {
        return new UserCollection(User::paginate(6));
    });

    $response = $this->get('/test/users');

    $response->assertOk();

    $this->assertArrayNotHasKey('meta', $response->collect());
    $this->assertArrayNotHasKey('links', $response->collect());
});
