<?php

use App\Http\Resources\XyzCollection;
use App\Http\Resources\XyzResource;
use Illuminate\Support\Facades\File;
use ToneflixCode\ResourceModifier\Services\Json\JsonResource;
use ToneflixCode\ResourceModifier\Services\Json\ResourceCollection;
use ToneflixCode\ResourceModifier\Tests\Models\User;

test('can create modified resource collection', function () {

    $this->artisan('mod:resource XyzCollection')->assertExitCode(0);

    expect(XyzCollection::class)->toBe('App\Http\Resources\XyzCollection');
});

test('can create modified resource', function () {

    $this->artisan('mod:resource XyzResource')->assertExitCode(0);

    expect(XyzResource::class)->toBe('App\Http\Resources\XyzResource');
});

test('can assure that modified resource collection is valid', function () {

    $outputPath = realpath(__DIR__.'/../../vendor/orchestra/testbench-core/laravel/app/Http/Resources/XyzCollection.php');
    if ($outputPath) {
        unlink($outputPath);
    }
    $this->artisan('mod:resource XyzCollection')->assertExitCode(0);

    User::factory(10)->create();

    $content = '';

    if ($outputPath) {
        $content = File::get($outputPath);
    }

    expect(stripos($content, ResourceCollection::class) >= 0)->toBeTrue();
});

test('can assure that modified resource is valid', function () {

    $outputPath = realpath(__DIR__.'/../../vendor/orchestra/testbench-core/laravel/app/Http/Resources/XyzResource.php');
    if ($outputPath) {
        unlink($outputPath);
    }
    $this->artisan('mod:resource XyzResource')->assertExitCode(0);

    User::factory(10)->create();

    $content = '';

    if ($outputPath) {
        $content = File::get($outputPath);
    }

    expect(stripos($content, JsonResource::class) >= 0)->toBeTrue();
});
