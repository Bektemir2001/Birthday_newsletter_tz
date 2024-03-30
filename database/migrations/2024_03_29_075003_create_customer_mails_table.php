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
        Schema::create('customer_mails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('mail_id');
            $table->unsignedSmallInteger('status')->default(0);
            $table->timestamps();

            $table->index('customer_id');
            $table->index('mail_id');

            $table->foreign('customer_id')
                ->on('customers')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreign('mail_id')
                ->on('mailings')
                ->references('id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_mails');
    }
};
