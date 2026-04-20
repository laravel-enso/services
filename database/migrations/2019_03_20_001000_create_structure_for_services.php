<?php

use LaravelEnso\Migrator\Database\Migration;

return new class() extends Migration {
    protected array $permissions = [
        ['name' => 'services.index', 'description' => 'Show index for service', 'is_default' => false],
        ['name' => 'services.create', 'description' => 'Create service', 'is_default' => false],
        ['name' => 'services.store', 'description' => 'Store a new service', 'is_default' => false],
        ['name' => 'services.edit', 'description' => 'Edit service', 'is_default' => false],
        ['name' => 'services.update', 'description' => 'Update service', 'is_default' => false],
        ['name' => 'services.destroy', 'description' => 'Delete service', 'is_default' => false],
        ['name' => 'services.initTable', 'description' => 'Init table for service', 'is_default' => false],
        ['name' => 'services.tableData', 'description' => 'Get table data for service', 'is_default' => false],
        ['name' => 'services.exportExcel', 'description' => 'Export excel for service', 'is_default' => false],
        ['name' => 'services.options', 'description' => 'Get service options for select', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Services', 'icon' => 'handshake', 'route' => 'services.index', 'order_index' => 230, 'has_children' => false,
    ];
};
