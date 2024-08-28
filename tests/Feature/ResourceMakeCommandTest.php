<?php

use App\Http\Resources\XyzCollection;
use Illuminate\Support\Facades\File;
use ToneflixCode\ResourceModifier\Services\Json\ResourceCollection;
use ToneflixCode\ResourceModifier\Tests\Models\User;

test('can create modified resource collection', function () {

    $this->artisan('mod:resource XyzCollection')->assertExitCode(0);

    expect(XyzCollection::class)->toBe('App\Http\Resources\XyzCollection');
});

test('can assure that modified resource collection is valid', function () {

    $outputPath = realpath(__DIR__ . '/../../vendor/orchestra/testbench-core/laravel/app/Http/Resources/XyzCollection.php');
    if ($outputPath) {
        unlink($outputPath);
    }
    $this->artisan('mod:resource XyzCollection')->assertExitCode(0);

    User::factory(10)->create();


    $content = '';

    if ($outputPath) {
        $content = str(File::get($outputPath));
    }

    expect($content->contains(ResourceCollection::class))->toBeTrue();
});