<?php include 'connection.php';?>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Page</title>
  <style type="text/css">
    form {
      width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      background-color: #f2f2f2;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 2px solid #ccc;
      border-radius: 4px;
    }
    input[type="submit"] {
      width: 100%;
      background-color: #4CAF50;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <form action="" method="post">
    <h1>Login</h1>
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" name="submit" value="Login">
    <a href="/eventmanagement/admin/regform" >Create An Account<a>
  </form>
 
</body>
</html>

<?php
if(isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
    $stmt = $conn->prepare("SELECT * FROM user WHERE _userName = :username AND _userPassword = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $result = $stmt->fetch();

    if($result) {
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['user_id'] = $result['_userId'];
      $_SESSION['adminId'] = $result['_isAdmin'];
      $_SESSION['_userbatch'] = $result['_userbatch'];
      header("Location: /eventmanagement/admin/dashboard.php");
      exit;
    } else {
      echo "<script>alert('Invalid username or password');</script>";
    }
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}
?>