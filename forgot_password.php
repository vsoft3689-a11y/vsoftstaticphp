<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email exists
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in the password_resets table
        $sql = "INSERT INTO password_resets (email, token) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();

        // Send OTP email
        mail($email, "Password Reset OTP", "Your OTP is: $otp");

        echo "OTP sent to your email.";
    } else {
        echo "Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<form method="POST" action="forgot_password.php">
    <input type="email" name="email" required placeholder="Enter your email"><br>
    <button type="submit">Send OTP</button>
</form>
