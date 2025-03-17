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
        Schema::table('billings', function (Blueprint $table) {
            Schema::table('billings', function (Blueprint $table) {
                if (Schema::hasColumn('billings', 'file_path_invoice')) {
                    $table->dropColumn('file_path_invoice');
                }
                
                $table->unsignedInteger('invoice_id')
                      ->after('user_id');
            });

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->string('file_path_invoice')->nullable();
            $table->dropColumn('invoice_id');
        });

    }
};
