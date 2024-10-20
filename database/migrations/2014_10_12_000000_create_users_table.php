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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 60);
            $table->string('username', 40)->nullable();
            $table->string('password', 100);
            $table->tinyInteger('is_active')->default(1)->comment('0 = tidak aktif, 1 = aktif');
            $table->smallInteger('user_type')->default(20)->comment('1 = admin, 10 = User Member');
            
            $table->timestamp('active_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->rememberToken();
            
            
            $table->index('name');
            $table->index('username');
            $table->index('password');
            $table->index('is_active');
            $table->index('user_type');
            $table->index('active_at');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
