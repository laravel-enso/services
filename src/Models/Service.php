<?php

namespace LaravelEnso\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\DynamicMethods\Contracts\DynamicMethods;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Helpers\Traits\AvoidsDeletionConflicts;
use LaravelEnso\MeasurementUnits\Models\MeasurementUnit;
use LaravelEnso\Rememberable\Traits\Rememberable;
use LaravelEnso\Tables\Traits\TableCache;

class Service extends Model implements DynamicMethods
{
    use Abilities, ActiveState, AvoidsDeletionConflicts, HasFactory;
    use TableCache, Rememberable;

    protected $guarded = ['id'];

    public function measurementUnit()
    {
        return $this->belongsToMan(MeasurementUnit::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(
            Company::class,
            'service_supplier',
            'service_id',
            'supplier_id'
        );
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
