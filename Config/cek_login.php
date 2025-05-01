<?php

include 'DB.php'; // Ensure this file creates a PDO instance and assigns it to $PDO

if (isset($_POST['log'])) {
    // Prepare the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = :email AND password = :password");

    // Get the email and password from the POST request
    $email = $_POST['email'];
    $pass = md5($_POST['password']); // Hash the password

    // Bind parameters
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pass);

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $email = $data['email'];
        $password = $data['password'];
        $level = $data['level'];

        // Check if the user exists
        if ($email && $pass === $password) {
            session_start();
            $_SESSION['nama'] = $email;
            $_SESSION['level'] = $level;

            if ($level === 'admin') {
                echo "<script> alert('Anda berhasil Login. Sebagai : $level');</script>";
                echo "<meta http-equiv='refresh' content='0; url=../dashboard.php'>";
            } else {
                echo "<script> alert('Anda berhasil Login. Sebagai : $level');</script>";
                echo "<meta http-equiv='refresh' content='0; url=guest/index.php'>";
            }
        } else {
            echo "<script> alert('Username dan Password Tidak Ditemukan');</script>";
            echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
        }
    } else {
        echo "<script> alert('Username dan Password Tidak Ditemukan');</script>";
        echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
    }
}
?>