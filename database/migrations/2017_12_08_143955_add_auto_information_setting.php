<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoInformationSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('bot_users', function (Blueprint $table) {
			$table->boolean('informator_enabled')->default(false);
			$table->string('informator_time', 50)->nullable()->default('30000');
			$table->unsignedInteger('informator_limit')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('bot_users', function (Blueprint $table) {
			$table->dropColumn('informator_enabled');
			$table->dropColumn('informator_time');
			$table->dropColumn('informator_limit');
		});
    }
}
