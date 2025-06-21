<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->string('isbn', 13);
            $table->unsignedSmallInteger('pages_count');
            $table->timestamp('published_at')->nullable()->default(null);
            $table->text('thumbnail_url')->nullable()->default(null);
            $table->text('short_description')->nullable()->default(null);
            $table->text('long_description')->nullable()->default(null);
            $table->string('status');

            $table->unique('isbn');

            $table->timestamps();
        });

        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);

            $table->unique('name');

            $table->timestamps();
        });

        Schema::create('author_book', function (Blueprint $table) {
            $table->foreignId('author_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('book_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['book_id', 'author_id']);
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);

            $table->timestamps();
        });

        Schema::create('book_category', function (Blueprint $table) {
            $table->foreignId('book_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('category_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(['book_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('author_book');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('books');
    }
};
