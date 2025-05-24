<?php

use App\Models\Request;
use App\Models\Step;
use App\Models\User;
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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Request::class, 'request_id')->constrained();
            $table->foreignIdFor(Step::class, 'step_id')->constrained();
            $table->foreignIdFor(User::class, 'approver_id')->constrained();
            $table->integer('status');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
