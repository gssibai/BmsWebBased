<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test editUsers method with no selected users.
     *
     * @return void
     */
    public function testEditUsersWithNoSelectedUsers()
    {
        $response = $this->post('/edit-users', ['userIds' => null]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Please select at least one user to update.');
    }

    /**
     * Test editUsers method with selected users.
     *
     * @return void
     */
    public function testEditUsersWithSelectedUsers()
    {
        // Create some dummy users
        $users = User::factory()->count(3)->create();

        // Select the first two users
        $selectedUserIds = $users->take(2)->pluck('id')->implode(',');

        $response = $this->post('/edit-users', ['userIds' => $selectedUserIds]);

        $response->assertViewIs('update_users');
        $response->assertViewHas('users', function ($users) {
            return $users->count() === 2;
        });
    }
}