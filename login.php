<?php
@session_start();
if(@$_SESSION["admin"] || @$_SESSION["user"]) {
    echo "<script>location='public/index.php'</script>";
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style type="text/css">
        body {
            background-color: rgb(100, 149, 237); /* RGB background color */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: first baseline;
            height: 100vh;
        }

        .rangkalogin {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
            width: 100%;
            max-width: 300px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 80px; /* Adjust the width as needed */
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin: 5px 0;
            width: 95%;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input[type="submit"] {
            padding: 10px;
            width: 100%;
            background-color: rgb(50, 150, 200);
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s; /* Add transition for color change */
        }

        input[type="submit"]:hover {
            background-color: rgb(255, 0, 0); /* Change the color to red on hover */
        }

        h2 {
            text-align: center;
            color: rgb(50, 50, 50);
        }

        .error-message {
            color: rgb(255, 0, 0);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="rangkalogin">
        <div class="logo">
            <img src="./img/user_logo2.png" alt="User Logo"> <!-- Replace with your user logo image -->
        </div>
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="text" name="user" placeholder="Username">
            <input type="password" name="pass" placeholder="Password">
            <input type="submit" name="tombol" value="Login">
        </form>
        <?php
        include "config.php";
        @session_start();
        $user = $koneksi->real_escape_string(@$_POST["user"]);
        $pass = $koneksi->real_escape_string(md5(@$_POST["pass"]));

        if($koneksi->real_escape_string(@$_POST["tombol"])) {
            $data = $koneksi->query("SELECT * FROM tb_login WHERE
            username='$user' AND password='$pass'");
            $ambildata = $data->fetch_array();
            $hitung = $data->num_rows;

            if($hitung > 0){
                if($ambildata["level"] == "admin"){
                    if ($_SESSION["admin"] = $ambildata){
                        $aktif = @$_SESSION["admin"]["id_login"];
                        $koneksi->query("UPDATE tb_login SET status='online'
                             WHERE id_login='$aktif'");
                        echo "<script>location='public/index.php';</script>";
                    }
                } else if($ambildata["level"] == "user"){
                    if ($_SESSION["user"] = $ambildata){
                        $aktif = @$_SESSION["user"]["id_login"];
                        $koneksi->query("UPDATE tb_login SET status='online'
                             WHERE id_login='$aktif'");
                        echo "<script>location='public/index.php';</script>";
                    }
                }

            } else {
                echo "<p class='error-message'>Username/password salah!!</p>";
            }
        }
        ?>
    </div>
</body>
</html>
<?php } ?>
