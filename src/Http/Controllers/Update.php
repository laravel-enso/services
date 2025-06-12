<?php

namespace LaravelEnso\Services\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Services\Http\Requests\ValidateService;
use LaravelEnso\Services\Models\Service;

class Update extends Controller
{
    public function __invoke(ValidateService $request, Service $service)
    {
        $service->update($request->only(
            ['measurement_unit_id', 'name', 'code', 'list_price',
             'vat_percent', 'description', 'is_active']
        ));
        $service->suppliers()->sync($request->get('suppliers'));

        return ['message' => __('The service was successfully updated')];
    }
}
