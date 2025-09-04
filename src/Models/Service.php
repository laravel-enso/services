<?php

namespace LaravelEnso\Services\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(
            Company::class,
            'service_supplier',
            'service_id',
            'supplier_id'
        )->withPivot(['acquisition_price'])
            ->as('cost')
            ->withTimeStamps();
    }

    public function supplierListPrice(Company $company): string
    {
        $supplier = $this->suppliers
            ->first(fn ($supplier) => $supplier->id === $company->id);

        return $supplier?->cost->acquisition_price ?? $this->list_price;
    }

    public function syncSuppliers(array $suppliers): self
    {
        $costs = Collection::wrap($suppliers)->mapWithKeys(fn ($supplier) => [
            $supplier['id'] => [
                'acquisition_price' => $supplier['cost']['acquisitionPrice'],
            ],
        ]);

        $this->suppliers()->sync($costs);

        return $this;
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
