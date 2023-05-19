<?php

namespace Tests\Feature;

use App\Models\StatusTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    private $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMix();
        $this->assertTrue(true);

        $this->user = User::factory()->create([
            'name' => 'DavidR',
            'first_name' => 'David',
            'last_name' => 'Rosas',
            'email' => 'davidTest@example.com',
        ]);

    }
    public function test_add_ata()
    {

        User::factory()->create([
            'name' => "DavidR",
            'first_name' => 'David',
            'last_name' => 'Rosas',
            'email' => 'davidr@example.com',
            'password' => bcrypt(123123),
        ]);

        User::factory()->create([
            'name' => "DavidR1",
            'first_name' => 'David1',
            'last_name' => 'Rosas1',
            'email' => 'davidr1@example.com',
            'password' => bcrypt(123123),
        ]);
        User::factory()->create([
            'name' => "DavidR2",
            'first_name' => 'David2',
            'last_name' => 'Rosas2',
            'email' => 'davidr2@example.com',
            'password' => bcrypt(123123),
        ]);

        StatusTask::create(['name' => 'Creada']);
        StatusTask::create(['name' => 'En progreso']);
        StatusTask::create(['name' => 'Finalizada']);
    }

    public function test_can_view_tasks()
    {
        // $this->actingAs($this->user)
        //     ->get('/task')->
        //     assertSee('"failed":true', true)
        //     ->assertInertia(fn(Assert $page) => $page
        //             ->component('Task/Index')
        //             ->has('tasks', fn(Assert $page) => $page
        //                     ->where('id', 0)
        //                     ->where('name', 'Make Food')
        //                     ->where('description', 'Food premiun')
        //                     ->where('status_task_id', 'Finalizada')
        //                     ->where('user_id', $this->user->id)
        //                     ->where('created_at', '2014-06-26 04:07:31')
        //             )
        //     );

    }

    public function test_create_task()
    {

        Task::create(
            [
                'name' => 'Make Food',
                'description' => 'To make food in the evening',
                'user_id' => $this->user->id,

            ]
        );

        Task::create(
            [
                'name' => 'Sport',
                'description' => 'To practice sport at night',
                'user_id' => $this->user->id,

            ],
        );
    }

}
