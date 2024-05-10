<?php

include '../components/connect.php';

session_start();

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if ($select_admin->rowCount() > 0) {
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   } else {
      $message[] = 'incorrect username or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/login.css">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />



   <style>
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: 'Poping', sans-serif;
      }

      body {
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
         background: #25252b;
      }

      @property --a {
         syntax: '<angle>';
         inherits: false;
         initial-value: 0deg;
      }

      .box {
         position: relative;
         width: 400px;
         height: 200px;
         background: repeating-conic-gradient(from var(--a), #ff2770 0%,
               #ff2770 5%, transparent 5%, transparent 40%, #ff2770 50%);
         filter: drop-shadow(0 15px 50px #000);
         border-radius: 20px;
         animation: rotating 4s linear infinite;
         display: flex;
         justify-content: center;
         align-items: center;
         transition: 0.5s;
      }

      .box:hover {
         width: 400px;
         height: 500px;
      }

      @keyframes rotating {
         0% {
            --a: 0deg
         }

         100% {
            --a: 360deg
         }
      }

      .box::before {
         content: '';
         position: absolute;
         width: 100%;
         height: 100%;
         background: repeating-conic-gradient(from var(--a), #45f3ff 0%,
               #45f3ff 5%, transparent 5%, transparent 40%, #45f3ff 50%);
         filter: drop-shadow(0 15px 50px #000);
         border-radius: 20px;
         animation: rotating 4s linear infinite;
         animation-delay: -1s;
      }

      .box:after {
         content: '';
         position: absolute;
         inset: 4px;
         background: #2d2d39;
         border-radius: 15px;
         border: 8px solid #25252b;
      }

      .login {
         position: absolute;
         inset: 60px;
         display: flex;
         justify-content: center;
         align-items: center;
         flex-direction: column;
         border-radius: 10px;
         background: rgba(0, 0, 0, 0.2);
         z-index: 1000;
         box-shadow: inset 10px 20px rgba(0, 0, 0, 0.2);
         border-bottom: 2px solid rgba(255, 255, 255, 0.5);
         transition: 0.5s;
         color: #fff;
         overflow: hidden;
      }

      .box:hover .login {
         inset: 40px;
      }

      .loginBx {
         position: relative;
         display: flex;
         justify-content: center;
         align-items: center;
         flex-direction: column;
         gap: 20px;
         width: 70%;
         transform: translateY(130px);
         transition: 0.5s;
      }

      .box:hover .loginBx {
         transform: translateY(0px);
      }

      .loginBx h2 {
         text-transform: uppercase;
         font-weight: 600;
         letter-spacing: .2em;
      }

      .loginBx h2 i {
         color: #ff2770;
         text-shadow: 0 0 5px #ff2770, 0 0 25px #ff2770;
      }

      .loginBx input {
         width: 100%;
         padding: 10px 20px;
         outline: none;
         border: none;
         font-size: 1em;
         color: #fff;
         background: rgba(0, 0, 0, 0.1);
         border: 2px solid #fff;
         border-radius: 30px;
      }

      .loginBx input::placeholder {
         color: #999;
      }

      .loginBx input[type="submit"] {
         background: #45f3ff;
         border: none;
         font-weight: 500;
         color: #111;
         cursor: pointer;
         transition: 0.5s;
      }

      .loginBx input[type="submit"]:hover {
         box-shadow: 0 0 10px #45f3ff;
      }

      .group {
         width: 100%;
         display: flex;
         justify-content: space-between;
      }

      .group {
         color: #fff;
      }

      .group span {
         color: #ff2770;
         font-weight: 700;
         gap: 2rem;
      }

      .group a:nth-child(2) {
         color: #ff2770;
         font-weight: 600;
      }
   </style>

</head>

<body>

   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
   ?>

   <div class="box">
      <form action="" method="post">
         <div class="login">
            <div class="loginBx">
               <h2>
                  <i class="fa-solid fa-right-to-bracket"></i>
                  Login
                  <i class="fa-solid fa-heart"></i>
               </h2>

               <input type="text" name="name" required placeholder="enter your username" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '') ">
               <input type="password" name="pass" required placeholder="enter your password" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
               <input type="submit" value="Login now" class="btn" name="submit">
               <div class="group">
                  <p>default username = <span> admin </span>password = <span> 111 </span></p>
               </div>

            </div>
         </div>
      </form>
   </div>
</body>

</html>