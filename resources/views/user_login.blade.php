<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>User Login</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Login Form Template" name="keywords">
        <meta content="Login Form Template" name="description">

        <!-- Favicon -->
        <link href="{{ url('img/favicon.ico') }}" rel="icon">

        <!-- Stylesheet -->
        <link href="{{ url('css/style5.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="wrapper login-1">
            <div class="container">
                <div class="col-left">
                
                </div>
                <div class="col-right">
                    @if($errors->any())
                    @foreach($errors->all() as $errors)
                    <ul>
                        <li>{{$errors}}</li>
                    
                    </ul>
                    @endforeach
                    @endif
                    
                        @if(session()-> has("message"))
                        <h3>{{session()->get("message")}}</h3>
                    
                    @endif
        
                    <div class="login-form">
                        <h2>Login</h2>
                        <form method="POST" action="/send_user_login">
                            @csrf
                            <p>
                                <label>Username<span>*</span></label>
                                <input type="text" placeholder="Username" name="username" required>
                            </p>
                            <p>
                                <label>Password<span>*</span></label>
                                <input type="password" placeholder="Password" name="password" required>
                            </p>
                            <p>
                                <input type="submit" value="Log In" />
                            </p>
                            
                        </form>
                    </div>
                </div>
            </div>
        
        </div>
    </body>
</html>
