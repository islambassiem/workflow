<?php

use App\Enums\Priority;
use App\Enums\Status;
use App\Mail\WorkflowRequestMail;
use App\Models\User;
use App\Models\Workflow;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Services\V1\StepApproverUserService;
use Database\Seeders\UserSeeder;
use Database\Seeders\WorkflowSeeder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Testing\Fluent\AssertableJson;

describe('authentication', function () {

    test('guest cannot access workflow resource collection', function () {
        $this->seed([UserSeeder::class, WorkflowSeeder::class]);
        $response = $this->getJson(route('requests.index'));
        $response->assertStatus(401);
    });

    test('guest cannot access a workflow resource', function () {
        $this->seed([UserSeeder::class, WorkflowSeeder::class]);
        $response = $this->getJson(route('requests.show', 1));
        $response->assertStatus(401);
    });

    test('guest cannot create a workflow', function () {
        $response = $this->postJson(route('requests.store'), []);
        $response->assertStatus(401);
    });

    test('guest cannot delete a workflow', function () {
        $response = $this->deleteJson(route('requests.destroy', 1));
        $response->assertStatus(401);
    });
});

describe('users can access requests', function () {

    test('authenticated users can access their own requests', function () {
        $this->seed();
        $user = User::factory()->has(WorkflowRequest::factory()->count(3), 'requests')->create();
        $response = $this->actingAs($user)->getJson(route('requests.index'));

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['data' => 3, 'meta', 'links'])->etc();
            });

        expect($response['data'])->each(function ($item) use ($user) {
            expect($item->value['user']['id'])->toBe($user->id);
            expect($item->value['user']['id'])->not->toBe(User::factory()->create()->id);
            expect($item->value['steps_count'])->toBeNumeric();
        });
    });

    test('authenticated users cannot access other users requests', function () {
        $this->seed();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('requests.index'));

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['data' => 0, 'meta', 'links'])->etc();
            });
    });

    test('authenticated users can access no requests page', function () {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('requests.index'));

        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['data' => 0, 'meta', 'links'])->etc();
            });
    });

    test('authenticated user can show a single request', function () {
        $this->seed([UserSeeder::class, WorkflowSeeder::class]);
        $user = User::factory()->has(WorkflowRequest::factory()->count(3), 'requests')->create();
        $request = WorkflowRequest::where('user_id', $user->id)->first();
        $response = $this->actingAs($user)->getJson(route('requests.show', $request->id));

        $response->assertStatus(200);

        expect($response['user']['id'])->toBe($user->id);
        expect($response['user']['id'])->not->toBe(User::factory()->create()->id);
    });

    test('authenticated user can create a request', function () {
        Mail::fake();
        $this->seed();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('requests.store'), [
            'workflow_id' => Workflow::first()->id,
            'priority' => Priority::LOW->value,
        ]);

        $firstStep = WorkflowRequestStep::find($response['steps'][0]['id']);

        $approvers = (new StepApproverUserService($firstStep))->handle();

        $response->assertStatus(201);
        expect($response['status'])->toBe(Status::PENDING->lable());
        expect($response['priority'])->toBe(Priority::LOW->lable());
        expect($response['data'])->toBeNull();
        expect($response['steps_count'])->toBeNumeric();
        expect($response['steps_count'])->toBeGreaterThan(0);

        $mailer = new WorkflowRequestMail($firstStep);
        $mailer->assertHasSubject('Workflow Request Mail');
        $mailer->assertSeeInHtml(' has created a new');
        $mailer->assertSeeInHtml('View Request');
        $mailer->assertSeeInHtml(config('app.front_end_url')."/approvals/requests/{$firstStep->id}/steps");
    });

    test('authenticated user can delete a request', function () {
        $this->seed([UserSeeder::class, WorkflowSeeder::class]);
        $user = User::factory()->has(WorkflowRequest::factory()->count(3), 'requests')->create();
        $request = WorkflowRequest::where('user_id', $user->id)->first();

        $response = $this->actingAs($user)->deleteJson(route('requests.destroy', $request->id));

        $response->assertStatus(204);
    });
});
