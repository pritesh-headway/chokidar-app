<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_service_providers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProvidersTable extends Migration
{
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->unsignedBigInteger('service_id');
            $table->string('mobile', 10);
            $table->text('address');
            $table->string('profile_image', 256);
            $table->json('documents')->nullable(); // To store multi-documents like pdf, jpg
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_providers');
    }
}
