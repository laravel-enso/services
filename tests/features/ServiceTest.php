<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelEnso\Forms\TestTraits\CreateForm;
use LaravelEnso\Forms\TestTraits\DestroyForm;
use LaravelEnso\Forms\TestTraits\EditForm;
use LaravelEnso\Services\Models\Service;
use LaravelEnso\Tables\Traits\Tests\Datatable;
use LaravelEnso\Users\Models\User;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use Datatable, DestroyForm, EditForm, CreateForm, RefreshDatabase;

    private $permissionGroup = 'services';
    private $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs(User::first());

        $this->testModel = Service::factory()->make();
    }

    /** @test */
    public function can_store_service()
    {
        $response = $this->post(
            route('services.store', [], false),
            $this->testModel->toArray()
        );

        $service = Service::whereName($this->testModel->name)
            ->first();

        $response->assertStatus(200)
            ->assertJsonStructure(['message'])
            ->assertJsonFragment([
                'redirect' => 'services.edit',
                'param' => ['service' => $service->id],
            ]);
    }

    /** @test */
    public function can_update_service()
    {
        tap($this->testModel)->save()->name = 'updated';

        $this->patch(
            route('services.update', $this->testModel->id, false),
            [...$this->testModel->toArray(), 'suppliers' => []]
        )->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertEquals(
            $this->testModel->name,
            $this->testModel->fresh()->name
        );
    }

    /** @test */
    public function get_option_list()
    {
        $this->testModel->save();

        $this->get(route('services.options', [
            'query' => $this->testModel->name,
            'limit' => 10,
        ], false))
            ->assertStatus(200)
            ->assertJsonFragment(['name' => $this->testModel->name]);
    }
}
