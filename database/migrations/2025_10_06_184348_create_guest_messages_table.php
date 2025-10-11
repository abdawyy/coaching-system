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
        Schema::create('guest_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();    // guest name
            $table->string('email')->nullable();   // guest email
            $table->string('mobile')->nullable();  // optional mobile
            $table->text('message');               // the message content
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_messages');
    }
};
