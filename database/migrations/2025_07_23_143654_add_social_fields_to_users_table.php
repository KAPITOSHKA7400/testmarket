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
		Schema::table('users', function (Blueprint $table) {
			$table->string('telegram')->nullable();
			$table->string('vk')->nullable();
			$table->string('xcom')->nullable(); // Twitter (x.com)
			$table->string('github')->nullable();
			$table->string('codepen')->nullable();
			$table->string('behance')->nullable();
			$table->string('linkedin')->nullable();
			$table->string('vimeo')->nullable();
			$table->string('youtube')->nullable();
		});
	}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
