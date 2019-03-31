<?php

use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsCollection extends Migration
{
    /**
     * The name of the database connection to use.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::connection($this->connection)->table('posts', function (Blueprint $collection) {
            $collection->index('id');
            $collection->unsignedInteger('user_id')->index();
            $collection->string('title');
            $collection->string('slug')->unique();
            $collection->string('image');
            $collection->longText('body');
            $collection->longText('short_body');
            $collection->boolean('published');
            $collection->dateTime('published_at');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->table('posts', function (Blueprint $collection) {
            $collection->drop();
        });
    }
}
