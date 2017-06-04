<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPagesMonthlyRevReviewsToHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_histories', function(Blueprint $table) {
            $table->integer('pages')->after('product_id');
            $table->integer('monthly_rev')->after('est');
            $table->integer('reviews')->after('monthly_rev');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_histories', function(Blueprint $table) {
            $table->dropColumn('reviews');
            $table->dropColumn('monthly_rev');
            $table->dropColumn('pages');
        });
    }
}
