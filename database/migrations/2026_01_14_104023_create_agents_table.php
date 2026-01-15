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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->foreignId('farmer_id')->nullable()->constrained('farmers')->nullOnDelete();
            $table->string('agent_code')->unique(); 
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('investors', function (Blueprint $table) {
            $table->foreignId('agent_id')->after('user_id')->nullable()->constrained('agents')->nullOnDelete();
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->foreignId('agent_id')->after('user_id')->nullable()->constrained('agents')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn('agent_id');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropForeign(['agent_id']);
            $table->dropColumn('agent_id');
        });

        Schema::dropIfExists('agents');
    }
};
