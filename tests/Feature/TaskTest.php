<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Carbon;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
             ->post('/task', [
                 'title' => 'Test Task',
                 'description' => 'Test Description',
                 'due_date' => now()->addDays(3)->toDateString(),
                 'status' => 'pending',
             ])
             ->assertRedirect('/task');

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'user_id' => $user->id
        ]);
    }
}
