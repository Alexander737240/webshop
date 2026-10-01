<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class CategoryCrudController extends CrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/category');
        CRUD::setEntityNameStrings('категорию', 'категории');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('id');
        CRUD::column('title')->label('Название');
        CRUD::column('slug')->label('Slug');
        CRUD::column('parent')
            ->type('select')
            ->label('Родитель')
            ->entity('parent')
            ->attribute('title');
        CRUD::column('active')->type('boolean')->label('Активна');
        CRUD::column('created_at')->type('datetime')->label('Создано');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'active' => 'boolean',
        ]);

        CRUD::field('title')->label('Название')->type('text');
        CRUD::field('slug')->label('Slug')->type('text')
            ->hint('Оставьте пустым — сгенерируется автоматически');
        CRUD::field('parent_id')->label('Родитель')->type('select')
            ->entity('parent')->attribute('title')
            ->model(Category::class)
            ->options(function ($query) {
                return $query->orderBy('title')->get();
            });
        CRUD::field('active')->label('Активна')->type('boolean')->default(true);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation(): void
    {
        $this->setupListOperation();
    }
}
