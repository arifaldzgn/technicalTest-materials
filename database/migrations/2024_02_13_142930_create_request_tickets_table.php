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
        Schema::create('request_tickets', function (Blueprint $table) {
            $table->id();
            $table->text('request_name');
            $table->bigInteger('account_id');
            $table->text('status');
            $table->text('revised')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_tickets');
    }
};

// Create([
//     'request_name' => 'Request name 1',
//     'account_id' => 1,
//     'status' => 'Pending'
// ]);