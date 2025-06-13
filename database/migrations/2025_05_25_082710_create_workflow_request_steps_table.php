<?php

use App\Models\User;
use App\Models\WorkflowRequest;
use App\Models\WorkflowStep;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workflow_request_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorkflowRequest::class)->constrained();
            $table->foreignIdFor(WorkflowStep::class)->constrained();
            $table->unsignedTinyInteger('order');
            $table->foreignIdFor(Role::class)->nullable()->constrained();
            $table->foreignIdFor(User::class, 'action_by')->nullable()->constrained();
            $table->unsignedTinyInteger('status')->default(1);
            $table->text('comment')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_request_steps');
    }
};
