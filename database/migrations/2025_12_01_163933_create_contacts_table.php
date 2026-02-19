<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->boolean('decision');
            $table->string('name');
            $table->enum('way_to_get_in_contact', ['phone', 'email', 'social_media', 'other_contact']);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('social_media')->nullable();
            $table->string('other_contact')->nullable();
            $table->boolean('foreign_city');
            $table->string('city');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->text('comments');
            $table->string('age')->nullable();
            $table->string('evangelist_name')->nullable();
            $table->foreignId('evangelist_church_id')->nullable()->constrained('churches')->nullOnDelete();
            $table->foreignId('follow_up_person')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('assigned')->default(false);
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('church_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('invalid_contact_details')->default(false);
            $table->boolean('not_interested')->default(false);
            $table->date('contacted_date')->nullable();
            $table->date('meeting_date')->nullable();
            $table->boolean('met')->default(false);
            $table->boolean('part_of_church')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
