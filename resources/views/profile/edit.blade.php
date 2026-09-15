
@extends('layouts.admin')

@section('title', 'Профиль')

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $user->avatar_url }}"
                         alt="{{ $user->name }}"
                         class="rounded-circle mb-3"
                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #e94560;">

                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>

                    @if($user->avatar)
                        <form action="{{ route('profile.avatar.destroy') }}" method="POST"
                              onsubmit="return confirm('Удалить аватар?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash me-1"></i> Удалить аватар
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-white fw-semibold">
                    <i class="fas fa-user-edit me-2"></i>Обновить профиль
                </div>
                <div class="card-body">
                    @if($errors->has('current_password') || $errors->has('password'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->get('current_password') as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                                @foreach($errors->get('password') as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Аватар</label>
                            <input type="file" name="avatar" accept="image/*"
                                   class="form-control">
                            <div class="form-text">
                                JPG, PNG, WEBP. Максимум 2 МБ.
                                При загрузке новая аватарка заменит старую.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Сохранить
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-white fw-semibold">
                    <i class="fas fa-key me-2"></i>Сменить пароль
                </div>
                <div class="card-body">
                    @if($errors->has('current_password') || $errors->has('password'))
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->only('current_password', 'password') as $messages)
                                    @foreach($messages as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Текущий пароль</label>
                            <input type="password" name="current_password"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Новый пароль</label>
                            <input type="password" name="password"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Повторите новый пароль</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-key me-1"></i> Сменить пароль
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
