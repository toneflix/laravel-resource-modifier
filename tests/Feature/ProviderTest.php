<?php

test('can publish config', function () {
    $this->artisan('vendor:publish --tag="resource-modifier"')
        ->assertExitCode(0);
});
