<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('event_id')->unsigned();
            $table->string("name");
            $table->string("email");
            $table->string("course");
            $table->integer('year_level')->unsigned();
            // NOTE: we will use the created_at as the ts where the student is marked present
            $table->timestamps();

            // INFO: attendance belongs to an event
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_attendances');
    }
};
