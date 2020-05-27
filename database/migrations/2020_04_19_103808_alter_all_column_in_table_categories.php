<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAllColumnInTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('c_all_child')->nullable()->after('c_is_parent');
            $table->tinyInteger('c_has_child')->default(0)->index()->after('c_is_parent');
            $table->integer('c_root_id')->default(0)->index()->after('c_is_parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['c_all_child','c_has_child','c_root_id']);
        });
    }
}
