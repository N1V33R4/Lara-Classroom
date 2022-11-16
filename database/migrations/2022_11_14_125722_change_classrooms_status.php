<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeClassroomsStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE classrooms MODIFY `status` ENUM('inactive', 'finished', 'current', 'future') NOT NULL;");
        // Schema::table('classrooms', function (Blueprint $table) {
        //     $table->enum('status', ['inactive', 'finished', 'current', 'future'])->change();
        // });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE classrooms MODIFY `status` ENUM('inactive', 'current', 'future') NOT NULL;");
    }
}
