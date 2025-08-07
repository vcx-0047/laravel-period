
public function up(): void { Schema::create('example', function (Blueprint $table) { 
    //if you want to use this you need to fix migrate.blueprint.php

    $table->period(); // this add 2 colomuns period_start and period_end });
}
