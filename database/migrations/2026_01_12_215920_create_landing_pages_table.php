<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPagesTable extends Migration
{
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // Same product ID as normal page
            $table->string('title'); // Headline for the landing page
            $table->string('slug')->unique(); // URL: yoursite.com/landing/slug
            $table->string('hero_image')->nullable();
            $table->string('video_url')->nullable(); // YouTube/Vimeo link
            $table->longText('description')->nullable(); // Main sales copy
            $table->text('feature_list')->nullable(); // Comma separated features
            $table->string('theme_color')->default('#cd171e'); // Customizable button color
            $table->string('phone_number')->nullable(); // Specific support number
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
}