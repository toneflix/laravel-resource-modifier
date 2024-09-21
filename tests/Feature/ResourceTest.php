<?php

use Illuminate\Support\Facades\Route;
use ToneflixCode\ResourceModifier\Tests\App\Http\Resources\UserResource;
use ToneflixCode\ResourceModifier\Tests\Models\User;

test('can convert resource to camel case', function () {

    $user = User::factory()->create();

    Route::get('test/users', function () use ($user) {
        return present(fn () => new UserResource($user));
    });

    $response = $this->get('/test/users');

    ! json_validate($response->content()) && $response->dump();

    $response->assertCreated();
    expect($response->collect('data')->keys()[3])->toBeCamelCase();
});
