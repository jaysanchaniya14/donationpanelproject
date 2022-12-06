<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title');
            $table->string('cover_image')->nullable();
            $table->enum('type', ['ongoing', 'fixed_goal']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('goal')->nullable();
            $table->string('donation_type')->nullable();
            $table->float('exchange_rate')->nullable();
            $table->text('description');
            $table->string('location');
            $table->boolean('is_completed')->default(false);
            $table->date('completion_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->nullOnDelete();
            $table->foreign('parent_id')->on('projects')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
