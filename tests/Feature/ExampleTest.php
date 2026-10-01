<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The homepage redirects to the admin dashboard,
     * which in turn sends guests to the login page.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('backpack.dashboard'));

        $this->followingRedirects()
            ->get('/')
            ->assertOk();
    }
}
