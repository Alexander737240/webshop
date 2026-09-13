@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>{{ $category->name }}</h1>

        <p><strong>ID:</strong> {{ $category->id }}</p>
        <p><strong>Slug:</strong> {{ $category->slug }}</p>
        <p><strong>Родитель:</strong> {{ $category->parent?->name ?? '—' }}</p>
        <p><strong>Описание:</strong> {{ $category->description ?? '—' }}</p>
        <p><strong>Создано:</strong> {{ $category->created_at }}</p>

        <h2>Дочерние категории</h2>
        <ul>
            @forelse($category->children as $child)
                <li>{{ $child->name }}</li>
            @empty
                <li>Нет дочерних категорий</li>
            @endforelse
        </ul>

        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Редактировать</a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Назад</a>
    </div>
@endsection
