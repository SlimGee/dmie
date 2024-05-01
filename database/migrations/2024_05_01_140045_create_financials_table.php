<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financials', function (Blueprint $table) {
            $table->id();
            $table->string('year', 4);
            $table->foreignId('company_id')->constrained('companies');
            $table->decimal('net_profit', 12, 2)->nullable();
            $table->decimal('total_assets', 12, 2)->nullable();
            $table->decimal('net_income', 12, 2)->nullable();
            $table->decimal('cash_flow_from_operations', 12, 2)->nullable();
            $table->decimal('cash_flow_from_investing_activities', 12, 2)->nullable();
            $table->decimal('average_net_operating_assets', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financials');
    }
};
