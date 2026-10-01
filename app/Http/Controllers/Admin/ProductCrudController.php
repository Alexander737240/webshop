<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ProductCrudController extends CrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/product');
        CRUD::setEntityNameStrings('товар', 'товары');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('id');
        CRUD::column('image')->type('image')->label('Фото')
            ->prefix('storage/')
            ->height('50px');
        CRUD::column('title')->label('Название');
        CRUD::column('category')->type('select')->label('Категория')
            ->entity('category')->attribute('title');
        CRUD::column('price')->type('number')->label('Цена')
            ->prefix('₽ ');
        CRUD::column('quantity')->type('number')->label('Кол-во');
        CRUD::column('active')->type('boolean')->label('Активен');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'active' => 'boolean',
        ]);

        CRUD::field('title')->label('Название')->type('text');
        CRUD::field('slug')->label('Slug')->type('text')
            ->hint('Оставьте пустым — сгенерируется автоматически');
        CRUD::field('category_id')->label('Категория')->type('select')
            ->entity('category')->attribute('title')
            ->model(Category::class)
            ->options(function ($query) {
                return $query->orderBy('title')->get();
            });
        CRUD::field('description')->label('Описание')->type('textarea');
        CRUD::field('price')->label('Цена')->type('number')
            ->attributes(['step' => '0.01']);
        CRUD::field('quantity')->label('Количество')->type('number');
        CRUD::field('image')->label('Фото')->type('upload')
            ->upload(true)->disk('public')->prefix('products');
        CRUD::field('active')->label('Активен')->type('boolean')->default(true);
    }

    protected function setupUpdateOperation(): void
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation(): void
    {
        $this->setupListOperation();
        CRUD::column('description')->type('textarea')->label('Описание');
    }
}
