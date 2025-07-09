<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'NganTeen')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
        }
        
        html, body {
            height: 100%;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
        }
        
        .content-wrapper {
            flex: 1 0 auto;
            width: 100%;
            padding-bottom: 2rem;
        }
        
        .footer {
            flex-shrink: 0;
            background-color: #212529;
            color: white;
            padding: 2rem 0;
            margin-top: auto;
            width: 100%;
        }
        
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        
        .card {
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: 0.5rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        .btn-custom {
            background-color: var(--primary);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            color: white;
        }
        
        .btn-custom:hover {
            background-color: var(--primary-dark);
            color: white;
        }
        
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="fas fa-utensils me-2"></i>NganTeen
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/pembeli/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('pembeli.orders.index')); ?>">Riwayat Pesanan</a>
                    </li>
                </ul>

                <div class="d-flex">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?php echo e(Auth::user()->name); ?>

                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <main class="py-4 container">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <footer class="footer mt-auto bg-dark text-white pt-4 pb-3">
        <div class="container">
            <div class="row mb-2">
                <div class="col-12 text-center">
                    <h5 class="mb-1">
                        <i class="fas fa-utensils me-2"></i>NganTeen
                    </h5>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0 text-muted small">
                        &copy; <?php echo e(date('Y')); ?> NganTeen. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
        }
        .footer {
            background-color: #2c3e50;
            background-image: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\NganTeen-main\resources\views/layouts/app.blade.php ENDPATH**/ ?>