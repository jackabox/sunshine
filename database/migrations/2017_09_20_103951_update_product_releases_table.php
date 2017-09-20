<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_releases', function (Blueprint $table) {
            $table->string('folder_name', 100)->nullable(true);
            $table->string('repo_name', 100)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_releases', function (Blueprint $table) {
            $table->dropColumn('repo_name');
            $table->dropColumn('folder_name');
        });
    }
}
