<?php

namespace LaravelEnso\Services\Dynamics;

use Closure;
use LaravelEnso\Companies\Models\Company;
use LaravelEnso\DynamicMethods\Contracts\Relation;
use LaravelEnso\Services\Models\Service;

class Services implements Relation
{
    public function bindTo(): array
    {
        return [Company::class];
    }

    public function name(): string
    {
        return 'services';
    }

    public function closure(): Closure
    {
        return fn (Company $company) => $company->belongsToMany(
            Service::class,
            'service_supplier',
            'supplier_id',
            'service_id'
        );
    }
}
