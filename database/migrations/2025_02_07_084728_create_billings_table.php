<?php

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
        Schema::create('billings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('membership_id');
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('cascade');
            $table->date('date');
            $table->date('due_date');
            $table->decimal('amount', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('file_path_invoice')->nullable();
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
