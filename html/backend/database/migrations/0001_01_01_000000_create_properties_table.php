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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description');
            $table->boolean('for_sale');
            $table->boolean('for_rent');
            $table->boolean('sold');
            $table->decimal('price')->unsigned();
            $table->string('currency', 10);
            $table->string('currency_symbol', 20);
            $table->string('property_type', 50);
            $table->integer('bedrooms_count');
            $table->integer('bathrooms_count');
            $table->decimal('area');
            $table->string('area_type', 10);

            $table->string('country', 100);
            $table->string('province', 100);
            $table->string('street', 1000);

            $table->string('photos_thumb', 1000);
            $table->string('photos_search', 1000);
            $table->string('photos_full', 1000);

            $table->timestamps();

            $table->index(['for_sale', 'sold']);
            $table->fullText('title');
            $table->index(['country', 'province']);
            $table->index('price');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
