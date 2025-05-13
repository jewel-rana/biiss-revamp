@extends("{$theme['default']}::layouts.auth")

@section('content')

    <form class="form-horizontal" method="POST" action="{{ route('auth.login.post') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="text-muted text-center">
                Enter your credentials
            </p>
        @endif
        <input type="hidden" name="g-recaptcha-response" id="recaptcha_token">
        <div class="form-group m-b-20">
            <input type="text" name="email" class="form-control form-control-lg"
                   placeholder="Email Address" required/>
        </div>
        <div class="form-group m-b-20">
            <input name="password" type="password" class="form-control form-control-lg"
                   placeholder="Password" required/>
        </div>
        <div class="login-buttons">
            <button type="submit" class="btn btn-primary btn-block btn-lg">Sign me in</button>
        </div>
    </form>

@endsection

@section('footer')
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('auth.recaptcha.site_key') }}"></script>
    <script>
        $(document).ready(function () {
            $('#toggle-password').click(function () {
                const passwordField = $('#password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);

                // Toggle the eye icon (open/closed)
                $(this).toggleClass('fa-eye fa-eye-slash');
            });
            grecaptcha.ready(function () {
                grecaptcha.execute('{{ config('auth.recaptcha.site_key') }}', {action: 'submit'}).then(function (token) {
                    document.getElementById('recaptcha_token').value = token;
                });
            });
        });
    </script>
@endsection
