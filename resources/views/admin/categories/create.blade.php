@extends('layouts.admin')

@section('title', 'Создать категорию')

@section('content')
    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Название <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug') }}"
                           class="form-control" placeholder="Оставьте пустым — сгенерируется автоматически">
                </div>

                <div class="mb-3">
                    <label class="form-label">Родительская категория</label>
                    <select name="parent_id" class="form-select">
                        <option value="">— Нет —</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>
                                {{ $parent->title }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Сохранить
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Назад
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
