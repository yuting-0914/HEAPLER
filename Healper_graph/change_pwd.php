<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>更改密碼</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #F2F2F2;
  }

  .change-password-container {
    background-color: #FFF;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 300px;
  }

  .change-password-container h2 {
    text-align: center;
    margin-bottom: 20px;
  }

  .change-password-container input[type="password"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #2C5C84;
    border-radius: 4px;
  }

  .change-password-container input[type="submit"] {
    width: 100%;
    background-color: #2C5C84;
    color: #FFF;
    border: none;
    padding: 10px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .change-password-container input[type="submit"]:hover {
    background-color: #999999;
  }
</style>
</head>
<body>
<div class="change-password-container">
  <h2>更改密碼</h2>
  <form action="update_pwd.php" method="post">
    <input type="password" name="new_password" placeholder="新密碼" required>
    <input type="password" name="confirm_password" placeholder="再次輸入新密碼" required>
    <input type="hidden" name="username" value="<?php echo $_GET['username']; ?>"> <!-- Pass username through a hidden input field -->
    <input type="submit" value="確認更改">
  </form>
</div>
</body>
</html>