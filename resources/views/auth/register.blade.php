
@extends('layouts.admin')

@section('title', 'Регистрация')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Регистрация</h2>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Повторите пароль</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-user-plus me-1"></i> Зарегистрироваться
                        </button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        Уже есть аккаунт? <a href="{{ route('login') }}">Войти</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
