<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Based Presentation App</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-classy {
            background-color: #1f2d3d;
        }
        .navbar-classy .navbar-brand,
        .navbar-classy .nav-link {
            color: #f8f9fa;
        }
        .navbar-classy .nav-link:hover {
            color: #ffc107; 
        }
        main {
            padding: 2rem 0;
            min-height: 85vh;
        }
        footer {
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            padding: 1rem 0;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }
        .navbar-nav {
            align-items: center;
        }
        .navbar-nav .nav-item {
            margin-left: 10px;
        }
        .logout-btn {
            text-decoration: none;
            background: none;
            border: none;
            color: #ffc107;
            padding: 0;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-classy shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/tutorial">WebPresentation</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (session()->get('refreshToken')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/tutorial">Daftar Tutorial</a>
                        </li>
                        <li class="nav-item">
                            <button class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <footer>
        &copy; <?= date('Y') ?> Aulia Anjali - WebPresentationApp
    </footer>

    <!-- Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="/logout" method="post" class="d-inline" id="logoutForm">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-warning">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
