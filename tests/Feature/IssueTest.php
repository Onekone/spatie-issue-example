<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IssueTest extends TestCase
{
    use RefreshDatabase;

    /** This is okay */
    public function test_WebFailed()
    {
        $user = $this->prepare();
        $this->actingAs($user)
            ->get('tokens/test-fail')
            ->assertForbidden();
    }

    public function prepare(): User
    {
        // Refresh and reseed database to ensure consistency
        $this->seed();

        // Confirm that auth guard list wasn't tampered
        $keys = array_keys(config('auth.guards'));
        $this->assertEquals('web', $keys[0], 'Order of the guards was tampered, cannot continue, sorry');
        $this->assertEquals('api', $keys[1], 'Order of the guards was tampered, cannot continue, sorry');

        // Pick a user from freshly seeded DB to use in test
        /** @var User $user */
        $user = User::with('roles.permissions')->limit(1)->get();

        // Assert that we actually got it
        $this->assertNotNull($user, 'There was no user? Is seed damaged?');
        $this->assertEquals([['weber', 'apier']], $user->pluck('roles.*.name')->toArray());
        $this->assertEquals([['nonapi', 'nonweb']], $user->pluck('roles.*.permissions.*.name')->toArray());

        // Return it so that we can test our cases
        return $user->first();
    }

    /** This is okay */
    public function test_WebSuccess()
    {
        $user = $this->prepare();
        $this->actingAs($user)
            ->get('tokens/test-success')
            ->assertOk();
    }

    /** This is not okay */
    public function test_ApiFailed()
    {
        $user = $this->prepare();

        $this->actingAs($user)
            ->get('api/tokens/test-fail')
            ->assertForbidden();
    }

    /** This is not okay */
    public function test_ApiSuccess()
    {
        $user = $this->prepare();

        $this->actingAs($user)
            ->get('api/tokens/test-success')
            ->assertOk();
    }
}
