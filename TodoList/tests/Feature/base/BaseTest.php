<?php

namespace Tests\Feature\base;

use Tests\TestCase;

class BaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->artisan('db:seed');
    }
}
