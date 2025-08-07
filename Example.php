<?php

namespace App\Models;

use App\Models\Traits\Period;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model; 

class Example  extends Model
{
    use   Period;

    // the shouldCheckPeriodConflict function will turn off or on  the period check that validate create and update 
    // its by default true but if you ok withe period start and end to overlap  use this 
    public function shouldCheckPeriodConflict(): bool 
    {
        return false; 
    }

}
