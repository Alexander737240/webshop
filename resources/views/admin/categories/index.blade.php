@extends('layouts.admin')

@section('title', 'Категории')

@section('header_actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Создать категорию
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Название</th>
                    <th>Slug</th>
                    <th>Родитель</th>
                    <th class="text-end" style="width: 160px;">Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="text-muted">#{{ $category->id }}</td>
                        <td class="fw-semibold">{{ $category->title }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ $category->parent?->title ?? '—' }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.show', $category) }}"
                               class="btn btn-sm btn-outline-info" title="Просмотр">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="btn btn-sm btn-outline-warning" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                        title="Удалить"
                                        onclick="return confirm('Удалить категорию?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p class="mb-0">Категорий пока нет</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="card-footer bg-white">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
