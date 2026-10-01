<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

class UserCrudController extends CrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use ShowOperation;
    use UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/user');
        CRUD::setEntityNameStrings('пользователя', 'пользователи');
    }

    protected function setupListOperation(): void
    {
        CRUD::column('id');
        CRUD::column('avatar')->type('image')->label('Аватар')
            ->prefix('storage/')
            ->height('40px');
        CRUD::column('name')->label('Имя');
        CRUD::column('email')->label('Email');
        CRUD::column('created_at')->type('datetime')->label('Регистрация');
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        CRUD::field('name')->label('Имя')->type('text');
        CRUD::field('email')->label('Email')->type('email');
        CRUD::field('password')->label('Пароль')->type('password');
        CRUD::field('password_confirmation')->label('Повтор пароля')->type('password');
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.CRUD::getCurrentEntryId(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        CRUD::field('name')->label('Имя')->type('text');
        CRUD::field('email')->label('Email')->type('email');
        CRUD::field('password')->label('Новый пароль')->type('password')
            ->hint('Оставьте пустым, чтобы не менять');
        CRUD::field('password_confirmation')->label('Повтор пароля')->type('password');
    }

    protected function setupShowOperation(): void
    {
        $this->setupListOperation();
        CRUD::column('avatar')->type('image')->prefix('storage/');
    }

    public function store()
    {
        $this->crud->hasAccessOrFail('create');

        $request = $this->crud->validateRequest();
        $request = $this->crud->getStrippedRequest();

        $request['password'] = Hash::make($request['password']);

        $this->crud->registerFieldEvents();

        $item = $this->crud->create($this->crud->getStrippedRequest());

        return $this->crud->getSaveResponse($item);
    }

    public function update()
    {
        $this->crud->hasAccessOrFail('update');

        $request = $this->crud->validateRequest();

        if (empty($request['password'])) {
            unset($request['password']);
        } else {
            $request['password'] = Hash::make($request['password']);
        }

        unset($request['password_confirmation']);

        $this->crud->registerFieldEvents();

        $item = $this->crud->update(
            $this->crud->getCurrentEntryId(),
            $this->crud->getStrippedRequest()
        );

        return $this->crud->getUpdateResponse($item);
    }
}
