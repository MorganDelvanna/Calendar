<?php
    require_once 'header.php';
    
    echo "<div><h3>Please enter your details to log in</h3>";
    $error = $user = $pass = "";

    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        $salt1 = "qv&lm*";
        $salt2 = "pl@!x";
        $token = hash('ripemd128', "$salt1$pass$salt2");

        if ($user == "" || $pass == "")
            $error = "Not all fields were entered<br />";
        else
        {
            $result = queryMySQL("SELECT UserName, Password FROM users WHERE UserName='$user' AND Password='$token'");

            if ($result->num_rows == 0)
            {
                $error = "<span class='error'>Username/Password invalid</span><br><br>";
            }
            else
            {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                echo "<script>window.location = 'eventList.php'</script>";
                die();
            }
        }
    }

    echo <<<_END
        <form method='post' action='login.php'>$error
        <span class='fieldname'>UserName</span><input type='text'
            maxlength='16' name='user' value ='$user'><br>
        <span class='fieldname'>Password</span><input type='password'
            maxlength='16' name='pass' value='$pass'>

        <br>
        <span class='Fieldname'>&nbsp;</span>
        <input type='submit' class='button' value='Login'>
        </form><br></div>
        </body>
        </html>
_END;
?>