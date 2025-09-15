<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF‑8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VSOFT | Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 100%; max-width: 380px;">
      <h4 class="text-center mb-4">Login to VSOFT</h4>
      <!-- <?php if ($error): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
      <?php endif; ?> -->
      <form method="post" action="">
        <div class="form-floating mb-3">
          <input type="email" name="email" id="email" class="form-control" placeholder="name@example.com" required>
          <label for="email">Email address</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
          <label for="password">Password</label>
        </div>
        <button type="submit" class="btn w-100" style="background-color : #0dcaf0"><a href="dashboard.php">Login</a></button>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
