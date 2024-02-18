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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_ticket_id');
            $table->text('material_name');
            $table->bigInteger('quantity');
            $table->text('usage');
            $table->text('revised')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};

// Create([
//     'request_ticket_id' => 1,
//     'material_name' => 'Sata Cable',
//     'quantity' => 20,
//     'usage' => 'Usage of Sata Cable'
// ],
// [
//     'request_ticket_id' => 1,
//     'material_name' => 'DPI Cable',
//     'quantity' => 12,
//     'usage' => 'Usage of DPI Cable'
// ]);
