<?php
session_start();

// Database connection details
// $servername = "localhost";
// $username = "root"; // Your MySQL username
// $password = ""; // Your MySQL password
// $dbname = "dpclass";
$servername = "127.0.0.1:3306";
$username = "u431598229_nit";
$password = "Faxfare@27";
$dbname = "u431598229_faxfare";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$msg = '';

if (isset($_POST['submit'])) {
    $userid = get_safe_value($conn, $_POST['userid']); // Use $userid for consistency
    $password = get_safe_value($conn, $_POST['password']);

    $sql = "SELECT * FROM `login` WHERE userid='$userid' and password='$password'"; // Correct variable name
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['IS_LOGIN'] = 'yes';
        $_SESSION['ADMIN_USER'] = $row['name'];

        redirect('../dashboard/Enquiry.php');
    } else {
        $msg = "Please enter valid login details";
    }
}

function get_safe_value($conn, $str) {
    $str = mysqli_real_escape_string($conn, $str);
    return $str;
}

function redirect($link) {
    ?>
    <script>
        window.location.href='<?php echo $link?>';
    </script>
    <?php
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>NIT Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            background: url('background.png');
            background-position: center;
            background-size: cover;
        }

        .form-box {
            position: relative;
            width: 400px;
            height: 450px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h2 {
            font-size: 2em;
            color: #fff;
            text-align: center;
        }

        .inputbox {
            position: relative;
            margin: 30px 0;
            width: 310px;
            border-bottom: 2px solid #fff;
        }

        .inputbox label {
            position: absolute;
            top: 50%;
            left: 5px;
            transform: translateY(-50%);
            color: #fff;
            font-size: 1em;
            transition: .5s;
        }

        input:focus ~ label,
        input:valid ~ label {
            top: -5px;
        }

        .inputbox input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            padding: 0 35px 0 5px;
            color: #fff;
        }

        .forget {
            margin: -15px 0 15px;
            font-size: .9em;
            color: #fff;
            display: flex;
            justify-content: center;
        }

        .forget label input {
            margin-right: 3px;
        }

        .forget label a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .forget label a:hover {
            text-decoration: underline;
        }

        button {
            width: 100%;
            height: 40px;
            border-radius: 40px;
            background: #fff;
            border: none;
            outline: none;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
        }

        .register {
            font-size: .9em;
            color: #fff;
            text-align: center;
            margin: 25px 0 10px;
        }

        .register p a {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
        }

        .register p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form method="post" action="">
                    <h2>Login</h2>
                    <div class="inputbox">
                        <input type="text" name="userid" id="username" required>
                        <label for="userid">Username</label>
                    </div>
                    <div class="inputbox">
                        <input type="password" name="password" id="password" required>
                        <label for="password">Password</label>
                    </div>
                    <button type="submit" name="submit">Log in</button>
                    <p id="message" style="color: white; text-align: center;"><?php echo $msg; ?></p>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
