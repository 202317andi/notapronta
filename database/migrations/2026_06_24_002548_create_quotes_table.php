<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('public_token')->unique();
            $table->enum('status', ['rascunho', 'enviado', 'aceito', 'recusado'])->default('rascunho');
            $table->decimal('total', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->datetime('sent_at')->nullable();
            $table->datetime('responded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
