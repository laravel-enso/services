<?php

namespace LaravelEnso\Services\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Services\Http\Requests\ValidateService;
use LaravelEnso\Services\Models\Service;

class Update extends Controller
{
    public function __invoke(ValidateService $request, Service $service)
    {
        $service->update($request->safe()->except('suppliers'));

        if (count($request->get('suppliers')) === 0) {
            $service->suppliers()->sync([]);
        } else {
            $service->syncSuppliers($request->get('suppliers'));
        }

        return ['message' => __('The service was successfully updated')];
    }
}
