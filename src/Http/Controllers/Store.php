<?php

namespace LaravelEnso\Services\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Services\Http\Requests\ValidateService;
use LaravelEnso\Services\Models\Service;

class Store extends Controller
{
    public function __invoke(ValidateService $request, Service $service)
    {
        $service->fill($request->safe()->except('suppliers'))->save();
        $service->suppliers()->sync($request->get('suppliers'));

        return [
            'message' => __('The service was successfully created'),
            'redirect' => 'services.edit',
            'param' => ['service' => $service->id],
        ];
    }
}
