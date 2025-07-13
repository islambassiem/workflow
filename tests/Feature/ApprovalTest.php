<?php

use App\Enums\Status;
use App\Mail\WorkflowRequestMail;
use App\Models\User;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Services\V1\StepApproverUserService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

describe('authorization', function () {

    test('unauthorized users cannot access request resource collection', function () {
        $this->getJson(route('approvals.index'))
            ->assertStatus(401);
    });

    test('unauthorized users cannot access a request resource', function () {
        $this->seed();
        $this->getJson(route('approvals.show', 1))
            ->assertStatus(401);
    });

    test('unauthorized users cannot update a request', function () {
        $this->seed();
        $this->postJson(route('approvals.update', [
            'request' => 1,
            'step' => 1,
        ]), [])
            ->assertStatus(401);
    });
});

describe('authorized user can take an action', function () {

    test('the step being approved does not beling to the request ', function () {
        $this->seed();
        $user = User::factory()->create();
        $request = WorkflowRequest::factory()->create([
            'user_id' => $user->id,
        ]);

        $step = WorkflowRequestStep::factory()->create([
            'workflow_request_id' => $request->id,
        ]);
        $approvers = (new StepApproverUserService($step))->handle();

        $response = $this->actingAs($approvers[0])->postJson(route('approvals.update', [
            'request' => 1,
            'step' => $step->id,
        ]), [
            'status' => Status::APPROVED->value,
            'comment' => 'approved',
        ]);

        $response->assertStatus(404);
    });

    test('the step being approved belings to the request', function () {
        Mail::fake();
        $this->seed();
        $user = User::factory()->create();
        $request = WorkflowRequest::factory()->create([
            'user_id' => $user->id,
        ]);

        $step = WorkflowRequestStep::factory()->create([
            'workflow_request_id' => $request->id,
        ]);
        $approvers = (new StepApproverUserService($step))->handle();

        $response = $this->actingAs($approvers[0])->postJson(route('approvals.update', [
            'request' => $request->id,
            'step' => $step->id,
        ]), [
            'status' => Status::APPROVED->value,
            'comment' => 'approved',
        ]);

        $response->assertStatus(200);

        $mailer = new WorkflowRequestMail($step, $approvers[0]->email);

        $mailer->assertHasSubject('Workflow Request Mail');
        $mailer->assertSeeInHtml(' has created a new');
        $mailer->assertSeeInHtml('View Request');
        $mailer->assertSeeInHtml(Config::get('app.front_end_url')."/approvals/requests/{$step->id}/steps");
    });
});
