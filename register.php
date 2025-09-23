<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<style>
    .register-box {
        display: flex;
        width: 100%;
        height: 100%;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .register-box h2 {
        margin-top: 30px;
    }

    #registerForm {
        width: 450px;
        height: 650px;
        text-align: center;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .register-box h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .register-box input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .register-box button {
        width: 100%;
        padding: 10px;
        background: #06BBCC;
        margin-top: 10px;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
    }

    .register-box button:hover {
        background: #06BBCC;
    }
</style>

<body>
    <?php include "./navbar.php" ?>
    <div class="register-box">
        <h2>Register Page</h2>
        <form id="registerForm" method="POST">
            <input type="text" name="name" placeholder="Full Name"><br>
            <input type="email" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="password_confirm" placeholder="Confirm Password"><br>
            <input type="text" name="phone" placeholder="Phone Number"><br>
            <input type="text" name="college" placeholder="College Name"><br>
            <input type="text" name="branch" placeholder="Branch Name"><br>
            <input type="text" name="year" placeholder="Year Passout"><br>
            <button type="submit">Register</button><br><br>
            <p>Already Registered? <a href="./login.php">Login Here</a></p>
        </form>
    </div>
    <?php include "./footer.php" ?>
</body>

<script>
     const apiUrl = "./controller/UserController.php";

        document.getElementById("registerForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            let form = e.target;
            let email = form.email.value.trim();
            let password = form.password.value.trim();

            try {
                let formData = new FormData(this);
                formData.append("action", "create");
                let response = await fetch(apiUrl, {
                    method: "POST",
                    body: formData
                });

                let data = await response.json();
                console.log(data);

                if (!data.success) {
                    alert(data.message);
                    return;
                }else{
                    alert(data.message);
                    window.location.href="./login.php";
                }

            } catch (error) {
                console.error("Error:", error);
                alert("Something went wrong. Please try again.");
            }
        });
</script>

</html>