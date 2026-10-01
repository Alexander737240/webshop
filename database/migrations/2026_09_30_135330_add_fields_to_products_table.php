<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('id')
                ->constrained()->nullOnDelete();
            $table->string('title')->after('category_id');
            $table->string('slug')->unique()->after('title');
            $table->text('description')->nullable()->after('slug');
            $table->decimal('price', 10, 2)->default(0)->after('description');
            $table->integer('quantity')->default(0)->after('price');
            $table->string('image')->nullable()->after('quantity');
            $table->boolean('active')->default(true)->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'category_id', 'title', 'slug', 'description',
                'price', 'quantity', 'image', 'active',
            ]);
        });
    }
};
