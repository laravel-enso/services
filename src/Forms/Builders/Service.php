<?php

namespace LaravelEnso\Services\Forms\Builders;

use LaravelEnso\Forms\Services\Form;
use LaravelEnso\Services\Http\Resources\Supplier;
use LaravelEnso\Services\Models\Service as Model;

class Service
{
    private const TemplatePath = __DIR__.'/../Templates/service.json';

    private $form;

    public function __construct()
    {
        $this->form = new Form($this->templatePath());
    }

    public function create()
    {
        return $this->form->create();
    }

    public function edit(Model $service)
    {
        return $this->form
            ->value('suppliers', Supplier::collection($service->suppliers))
            ->edit($service);
    }

    protected function templatePath(): string
    {
        return self::TemplatePath;
    }
}
