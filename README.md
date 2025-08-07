# laravel-period-
add period  to model in laravel project 

make /Traits/period.php in the model directory 

to use it in the model add this 

use App\Models\Traits\Period;

class example  extends Model
{
    use  Period;

    //rest of you functions 
}
in this there is a sevral method 

1- validate condition period end always after period start 

2- check conflict between athour period  always true only if you chose to turn it off 

to tun it of use this in the model 

 public function shouldCheckPeriodConflict(): bool 
   {
     return false;
   }

3-inPeriod($date) to select row where date is in the period 

if want to add the migrate 

add to /home/walid/Projects/laravel/zkteco/vendor/laravel/framework/src/Illuminate/Database/Schema/Blueprint.php
this line 
public function period()
    {
        return new Collection([
            $this->timestamp('period_start')->nullable(),
            $this->timestamp('period_end')->nullable(),
        ]);
    }
how to use it 

public function up(): void
    {
        Schema::create('example', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->period();  // this add 2 colomuns period_start and period_end
        });
    }





    














   

