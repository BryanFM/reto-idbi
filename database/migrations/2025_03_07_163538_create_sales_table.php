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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Código venta
            $table->string('client_name'); // Cliente nombre
            $table->string('client_identification_type'); // (DNI/RUC)
            $table->string('client_identification_number'); // Numero documento
            $table->string('client_phone')->nullable(); // Teléfono del cliente (opcional)
            $table->string('client_address')->nullable(); // Dirección del cliente (opcional)
            $table->string('client_city')->nullable(); // Ciudad del cliente (opcional)
            $table->string('client_email')->nullable(); // Correo del cliente (opcional)
            $table->decimal('total', 10, 2); // Total  venta
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Vendedor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
