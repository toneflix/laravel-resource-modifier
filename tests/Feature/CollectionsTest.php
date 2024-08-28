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
    $response->dump();
    $response->assertOk();

    $this->assertArrayHasKey('links', $response->collect());
    $this->assertArrayHasKey('meta', $response->collect());
    $this->assertArrayHasKey('data', $response->collect());
});