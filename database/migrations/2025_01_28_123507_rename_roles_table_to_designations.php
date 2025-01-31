<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRolesTableToDesignations extends Migration
{
    public function up()
    {
        Schema::rename('roles', 'designations');
    }

    public function down()
    {
        Schema::rename('designations', 'roles');
    }
}
