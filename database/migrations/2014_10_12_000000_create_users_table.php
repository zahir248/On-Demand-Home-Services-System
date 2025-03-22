<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20)->unique();
            $table->enum('role', ['admin', 'provider', 'customer'])->default('customer');
            $table->string('business_name')->nullable(); // Nullable for providers
            $table->text('address')->nullable(); // Nullable for providers
            $table->decimal('latitude', 10, 8)->nullable(); // Nullable for providers
            $table->decimal('longitude', 11, 8)->nullable(); // Nullable for providers
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->nullable(); // Nullable for providers
            $table->boolean('verified')->nullable(); // Nullable for providers
            $table->string('onesignal_player_id')->nullable(); // OneSignal Device ID for push notifications
            $table->string('profile_picture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
