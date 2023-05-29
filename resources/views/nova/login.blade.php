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
        <div class="form-group">
            <label for="loginDropdown">
                Select login method:
            </label>
            <select class="form-control" id="loginDropdown" required>
                <option selected disabled>Please choose</option>
                <option value="email">Email</option>
                <option value="phone">Phone</option>
            </select>
        </div>
        <div class="form-group" id="phoneContainer" style="display: none;">
            <label for="phone">Enter your number:</label>
            <input class="form-control" name="phone" placeholder="Enter number" type="text" id="phone">
        </div>

        <div class="form-group" id="emailContainer" style="display: none;">
            <label for="email">Enter your email:</label>
            <input class="form-control" placeholder="Enter email" name="email"  type="email" id="email">
        </div>
{{--        <div class="form-group">--}}
{{--            <label for="user_identity">--}}
{{--                Enter Phone/Email:--}}
{{--            </label>--}}
{{--            <input type="text" id="user_identity" value="{{old('user_identity')}}" name="user_identity"--}}
{{--                   class="form-control"--}}
{{--                   placeholder="Enter (phone/email)" required="required">--}}
{{--        </div>--}}
        <div class="form-group">
            <label for="password">
                Enter Password:
            </label>
            <input type="password" id="password" value="{{old('password')}}" name="password" class="form-control"
                   placeholder="Enter Password"
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
<script>
    $(document).ready(function () {
        $('#loginDropdown').change(function() {
            let selectedOption = $(this).val();

            if (selectedOption === 'phone') {
                $('#phoneContainer').show();
                $('#phone').val("880").disabled();
                $('#emailContainer').hide();
            } else if (selectedOption === 'email') {
                $('#phoneContainer').hide();
                $('#emailContainer').show();
            }
        });
    });
</script>
</html>




