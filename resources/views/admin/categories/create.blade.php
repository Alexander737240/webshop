@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Создать категорию</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Название</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Родительская категория</label>
                <select name="parent_id" class="form-control">
                    <option value="">— Нет —</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Описание</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Назад</a>
        </form>
    </div>
@endsection
