<?php

use App\Models\User;
use App\Models\Workflow;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Workflow::class)->constrained();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('order')->default(1);
            $table->string('approver_type');
            $table->unsignedBigInteger('approver_id');
            $table->foreignIdFor(User::class, 'created_by')->constrained();
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_requests');
    }
};
