<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_responses_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_id')->constrained('forums')->onDelete('cascade'); // foreign key referencing forum table
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // foreign key referencing users table
            $table->enum('status', ['active', 'deactive'])->default('active'); // status field
            $table->timestamps(); // created_at and updated_at fields
        });
    }

    public function down()
    {
        Schema::dropIfExists('responses');
    }
}
