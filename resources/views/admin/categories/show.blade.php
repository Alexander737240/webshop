@extends('layouts.admin')

@section('title', $category->title)

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $category->id }}</dd>

                <dt class="col-sm-3">Название</dt>
                <dd class="col-sm-9">{{ $category->title }}</dd>

                <dt class="col-sm-3">Slug</dt>
                <dd class="col-sm-9"><code>{{ $category->slug }}</code></dd>

                <dt class="col-sm-3">Родитель</dt>
                <dd class="col-sm-9">{{ $category->parent?->title ?? '—' }}</dd>

                <dt class="col-sm-3">Создано</dt>
                <dd class="col-sm-9">{{ $category->created_at?->format('d.m.Y H:i') }}</dd>
            </dl>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-white fw-semibold">Дочерние категории</div>
        <div class="card-body">
            <ul class="mb-0">
                @forelse($category->children as $child)
                    <li>{{ $child->title }}</li>
                @empty
                    <li class="text-muted">Нет дочерних категорий</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
            <i class="fas fa-edit me-1"></i> Редактировать
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Назад
        </a>
    </div>
@endsection
