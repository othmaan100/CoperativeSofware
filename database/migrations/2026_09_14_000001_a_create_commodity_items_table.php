<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_items', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('type_brand')->nullable();
            $table->string('pack_unit');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commodity_items');
    }
};
