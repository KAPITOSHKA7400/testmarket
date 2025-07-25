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
		Schema::table('works', function (Blueprint $table) {
			$table->boolean('is_gallery')->default(0);
			$table->boolean('gallery_main')->default(0);
			$table->string('gallery_group')->nullable();
		});
	}


    /**
     * Reverse the migrations.
     */
    public function down()
	{
		Schema::table('works', function (Blueprint $table) {
			$table->dropColumn(['is_gallery', 'gallery_main', 'gallery_group']);
		});
	}

};
