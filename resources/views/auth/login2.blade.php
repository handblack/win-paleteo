@extends('layouts.home')

@section('content')
    <div class="hold-transition login-page">


        <div class="login-box">
            
            
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg" style="font-size:1.6rem;"></p>
                    <form action="{{ route('login_submit') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="email" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    {{--

                                    <input type="checkbox" id="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                --}}
                                </div>
                            </div>

                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                            </div>

                        </div>
                    </form>
                    
                    {{-- 
                    <div class="social-auth-links text-center mb-3">
                        <p>&nbsp;</p>
                    </div>
                    <p class="mb-1">
                        <a href="#">Olvide mi contraseña</a>
                    </p>
                    --}}

                </div>
            </div>
            
        </div>
    </div>
@endsection
