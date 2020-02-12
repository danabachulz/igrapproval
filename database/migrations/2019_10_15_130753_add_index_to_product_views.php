<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexToProductViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_views', function(Blueprint $table)
        {
            $table->index('prdcd');
            $table->index('kode_igr');
            $table->index('kode_department');
            $table->index('kode_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_views', function (Blueprint $table)
        {
            $table->dropIndex('prdcd');
            $table->dropIndex('kode_igr');
            $table->dropIndex('kode_department');
            $table->dropIndex('kode_category');
        });
    }
}
