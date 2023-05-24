<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{\Illuminate\Support\Env::get('APP_NAME')}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="{{asset('assets/css/login.css')}}" rel="stylesheet">
</head>
<body class="login-form-body">
<div class="login-form">
    <form action="{{route('admin-login-check')}}" method="post">
        @csrf
        @method('POST')
        <div class="avatar">
            <img src="{{asset('img/sawari-logo.svg')}}" alt="logo" class="img-fluid"/>
        </div>
        <h4 class="modal-title">Welcome Back!</h4>
        <hr/>
        {{--        <div class="form-group">--}}
        {{--            <label for="email">--}}
        {{--                Enter Email:--}}
        {{--            </label>--}}
        {{--            <input type="text" id="email" name="email" class="form-control" placeholder="Username" required="required">--}}
        {{--        </div>--}}
        <div class="form-group">
            <label for="user_identity">
                Enter Phone/Email:
            </label>
            <input type="text" id="user_identity" value="{{old('user_identity')}}" name="user_identity" class="form-control"
                   placeholder="Enter (phone/email)" required="required">
        </div>
        <div class="form-group">
            <label for="password">
                Enter Password:
            </label>
            <input type="password" id="password" value="{{old('password')}}" name="password" class="form-control"
                   placeholder="Password"
                   required="required">
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
    </form>
</div>
</body>
</html>




