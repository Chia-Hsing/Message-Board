<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../css/sign_in1.css">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- JS -->
    <script src="./sign_in.js"></script>
</head>
<body>
    <div class="sign_in">
        <div class="form">
            <h2>SIGN IN</h2>
            <div class="group">
                <div>
                    <label for="username">Username</label>
                    <input class="psl_info" type="text" name="username">
                </div>
                <div>    
                    <label for="user_password">Password</label>
                    <input class="psl_info" type="password" name="user_password">
                </div>  
                <span class="sign_in_info"></span>
            </div>
            <div class="btn-group">
                <input type="submit" class="sign_in_btn" value="sign in">
                <a href="../sign-up/sign_up.php">New to this message board ? create a account</a>
            </div>   
        </div>     
    </div>
</body>

</html>
