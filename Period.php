<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

trait Period
{
    public static function bootPeriod()
    {
        static::creating(function (Model $model) {
            self::validatePeriod($model);

            if ($model->shouldCheckPeriodConflict()) {
                self::checkPeriodConflict($model);
            }
        });

        static::updating(function (Model $model) {
            self::validatePeriod($model, $model->id);

            if ($model->shouldCheckPeriodConflict()) {
                self::checkPeriodConflict($model, $model->id);
            }
        });
    }

    protected static function validatePeriod(Model $model, $excludeId = null)
    {
        $start = $model->start;
        $end = $model->end;

        if (!$start || !$end || $end <= $start) {
            throw ValidationException::withMessages([
                'end' => 'End date must be after start date.',
            ]);
        }
    }

    protected static function checkPeriodConflict(Model $model, $excludeId = null)
    {
        $start = $model->start;
        $end = $model->end;

        $query = $model
            ->newQuery()
            ->where(function ($q) use ($start, $end) {
                $q
                    ->whereBetween('start', [$start, $end])
                    ->orWhereBetween('end', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2
                            ->where('start', '<=', $start)
                            ->where('end', '>=', $end);
                    });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'start' => 'Period overlaps with an existing one.',
                'end' => 'Period overlaps with an existing one.',
            ]);
        }
    }

    public function scopeInPeriod($query, $date)
    {
        return $query
            ->where($this->getPeriodColumnEnd(), '>=', $date)
            ->where($this->getPeriodColumnStart(), '<=', $date);
    }

    public function getPeriodColumnStart(): string
    {
        return 'start';
    }

    public function getPeriodColumnEnd(): string
    {
        return 'end';
    }

    /**
     * Models using this trait can override this method
     */
    public function shouldCheckPeriodConflict(): bool
    {
        return true;
    }
}
