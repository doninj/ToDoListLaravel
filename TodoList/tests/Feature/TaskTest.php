<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_create_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/task', [
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'user_id' => $task->user_id,
        ]);
        expect($response->getStatusCode())->toBe(201)
            ->and($response->json())->toHaveKeys(['task']);
    }
}
