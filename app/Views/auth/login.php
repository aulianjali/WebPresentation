<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }
        .card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card h4 {
            font-size: 24px;
            font-weight: 500;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.12), inset 0 1px 2px rgba(0,0,0,0.24);
        }
        .btn-primary {
            background-color: #4a90e2;
            border-color: #4a90e2;
            font-weight: 500;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #357ab7;
            border-color: #357ab7;
        }
        .alert {
            background-color: #f44336;
            border-color: #f44336;
            color: #fff;
            border-radius: 8px;
        }
        .alert .btn-close {
            color: #fff;
        }
        .alert-success {
            background-color: #4caf50;
            border-color: #4caf50;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <h4>Login ke WebPresentationApp</h4>

    <!-- pesan sukses setelah logout -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- pesan error jika login gagal -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post" action="/login">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>
