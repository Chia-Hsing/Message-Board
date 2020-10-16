<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../css/sign_up2.css">
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- JS -->
    <script src="./sign_up.js"></script>
</head>
<body>
    <div class="sign_up">
        <div class="form">
            <h2>SIGN UP</h2>
            <div class="group">
                <div>
                    <label for="username">Username</label>
                    <input class="psl_info" type="text" name="username">
                </div>
                <div>    
                    <label for="user_password">Password</label>
                    <input class="psl_info" type="password" name="user_password">
                </div>  
                <div>    
                    <label for="confirm_password">Password Again</label>
                    <input class="psl_info" type="password" name="confirm_password">
                </div>
                <span class="sign_up_info"></span>  
            </div>
            <div class="btn-group">
                <input type="submit" value="sign up" class="sign_up_btn">
                <a href="../sign-in/sign_in.php">sign in instead</a>
        </div>    
    </div>
</body>


</html>
