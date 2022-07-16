<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('actions', function(Blueprint $table) {
            $table->id();

            /**
             * morphs adds the fields I need, but is slightly redundant when assuming
             * only users can commit actions. In the case a worker is doing something though,
             * I'd make this a nullable morph to allow for unauthenticated workers.
             * Ideally, workers will authenticate with the server. But, the nullable is a
             * quick and dirty way to get this working I think.             *
             */
            $table->morphs('performer');
            $table->morphs('subject');
            $table->enum('action_type', ['CREATE', 'UPDATE', 'DELETE']);
            $table->string('description')->nullable(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actions');
    }
};
