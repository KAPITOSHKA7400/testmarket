<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->string('avatar')->nullable();
			$table->string('phone')->nullable();
			$table->string('website')->nullable();
			$table->string('country')->nullable();
			$table->string('city')->nullable();
			$table->text('about')->nullable();
		});
	}


    /**
     * Reverse the migrations.
     */
    public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn(['avatar', 'phone', 'website', 'country', 'city', 'about']);
		});
	}
};
