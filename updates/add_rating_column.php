<?php namespace Flynsarmy\CommentableRatings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddRatingColumn extends Migration
{
    public function up()
    {
        Schema::table('flynsarmy_commentable_comments', function ($table) {
            $table->integer('rating')->index();
        });
    }

    public function down()
    {
        Schema::table('flynsarmy_commentable_comments', function ($table) {
            $table->dropColumn('rating');
        });
    }
}
