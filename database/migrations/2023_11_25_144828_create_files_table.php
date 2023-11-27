<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\FileType;
use App\Enums\ContentType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->bigInteger('user_id')->nullable();
            $table->enum('file_type',FileType::toValues())->default(FileType::IMAGE);
            $table->enum('content_type',ContentType::toValues())->default(ContentType::USER);
            $table->string('file_path');
            //$table->text('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
