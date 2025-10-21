<?php
session_start();
require_once __DIR__ . '/dist/config/config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error_message = "Both username and password are required.";
    } else {
        try {
            // Fetch admin by username
            $sql = "SELECT admin_id, username, password FROM admins WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':username' => $username]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if user exists and password matches
            if ($admin && ($password === $admin['password'])) {
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['username'] = $admin['username'];

                // Show success message instead of redirecting
               header("Location: dist/admin/dashboard.php");
            } else {
                $error_message = "Invalid username or password.";
            }

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            $error_message = "An error occurred. Please try again later.";
        }
    }
}

// Optional: display the error message
if (!empty($error_message)) {
    echo "<p style='color:red;'>$error_message</p>";
}
?>
<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
  <head>
    <title>index</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="." />
    <meta name="keywords" content="." />
    <meta name="author" content="Sniper 2025" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./dist/assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/feather.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="./dist/assets/fonts/material.css" />
    <link rel="stylesheet" href="./dist/assets/css/style.css" id="main-style-link" />
  </head>

  <style>
.sername{
  border-radius:5px;
  width: 60%;
  height:35px;
  position: relative;
  left:15px;
  top:180px;
}

.pass{
  border-radius:5px;
   width: 60%;
   height:35px;
    position: relative;
    top:245px;
    left:49px;

}

.btn{
  width: 100px;
  position:relative;
  right:180px;
  top:330px;
}

.background{
  border-radius:10px;
  background-color:#0c0039;
  width: 90%;
  height:600px;
  position:relative;
  left:45px;
}

.email{
  color:white;
  position:relative;
  top:130px;
  left:60px;
  font-size:15pt;
}
.password{
  font-size:15pt;
  color:white;
  position: relative;
  top:240px;
  right: 343px;
}



  </style>
  <body>
    <!-- [ Pre-loader ] start -->
 
    <!-- [ Pre-loader ] End -->
    <div class="auth-main relative">
      <div class="auth-wrapper v1 flex items-center w-full h-full min-h-screen justify-center">
          <div class="mt-4 text-center">
            
        <div class="background">
       
          <form  method="POST" >
            <label class="email">Email</label>
            <input type="text" placeholder="bloomsalon@gmail.com" name="username" class="sername" required>
            <label class="password">Password</label>
            <input type="password" placeholder="******" name="password" class="pass" required>
           <button type="submit" class="btn btn-primary mx-auto shadow-2xl">Enter</button>
            </div>
        </form>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="../dist/assets/js/plugins/simplebar.min.js"></script>
    <script src="../dist/assets/js/plugins/popper.min.js"></script>
    <script src="../dist/assets/js/icon/custom-icon.js"></script>
    <script src="../dist/assets/js/plugins/feather.min.js"></script>
    <script src="../dist/assets/js/component.js"></script>
    <script src="../dist/assets/js/theme.js"></script>
    <script src="../dist/assets/js/script.js"></script>

    <div class="floting-button fixed bottom-[50px] right-[30px] z-[1030]"></div>
    <script>
      layout_change('false');
      layout_theme_sidebar_change('dark');
      change_box_container('false');
      layout_caption_change('true');
      layout_rtl_change('false');
      preset_change('preset-1');
      main_layout_change('vertical');
    </script>
  </body>
</html>
