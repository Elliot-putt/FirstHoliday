<?php

namespace Tests;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use BotMan\BotMan\BotMan;
use BotMan\Studio\Testing\BotManTester;

abstract class TestCase extends BaseTestCase {

    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void
    {
        Parent::setUp();
    }

    public function login(User $user = null): User
    {

        $user ??= $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

}
