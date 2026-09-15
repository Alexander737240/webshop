
@extends('layouts.admin')

@section('title', 'Вход')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4 text-center">Вход</h2>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember"
                                   class="form-check-input" value="1">
                            <label for="remember" class="form-check-label">Запомнить меня</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-1"></i> Войти
                        </button>
                    </form>

                    <p class="text-center mt-3 mb-0">
                        Нет аккаунта? <a href="{{ route('register') }}">Зарегистрироваться</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
