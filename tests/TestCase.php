<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @before
     */
    public function boot(): void
    {
        $this->afterApplicationCreated(function () {
            $this->withoutVite();
        });
    }
}
