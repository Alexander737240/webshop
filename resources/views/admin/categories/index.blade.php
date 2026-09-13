@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Категории</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Создать категорию</a>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Slug</th>
                <th>Родитель</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->parent?->name ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-info">Просмотр</a>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">Редактировать</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $categories->links() }}
    </div>
@endsection
