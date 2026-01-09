<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Chirwa Électronique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: linear-gradient(180deg, #1a237e 0%, #283593 100%);
            min-height: 100vh;
            color: white;
        }

        .sidebar a {
            color: #e8eaf6;
            text-decoration: none;
            padding: 12px 15px;
            display: block;
            border-radius: 8px;
            margin: 5px 0;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #3949ab;
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-primary {
            background: linear-gradient(45deg, #3949ab, #303f9f);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-success {
            background: linear-gradient(45deg, #43a047, #2e7d32);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
        }

        .table th {
            background-color: #3949ab;
            color: white;
            border-color: #5c6bc0;
            font-weight: 600;
        }

        .badge-stock {
            font-size: 0.9em;
            padding: 6px 12px;
            font-weight: 500;
        }

        /* Logo Styles */
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .custom-logo {
            max-width: 180px;
            height: auto;
            margin: 0 auto 15px auto;
            display: block;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .logo-fallback {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #ff9800, #ff5722);
            border-radius: 50%;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.3);
            border: 3px solid white;
        }

        .logo-icon {
            font-size: 2.8rem;
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .company-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .logo-subtitle {
            font-size: 0.85rem;
            color: #c5cae9;
            margin-bottom: 3px;
            font-weight: 500;
        }

        .copyright {
            font-size: 0.75rem;
            color: #9fa8da;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Menu items with icons */
        .sidebar a i {
            width: 24px;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Export dropdown */
        .dropdown-menu {
            background: #3949ab;
            border: 1px solid #5c6bc0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .dropdown-item {
            color: #e8eaf6;
            padding: 10px 15px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #5c6bc0;
            color: white;
        }

        /* Main content header */
        h2 {
            color: #3949ab;
            font-weight: 700;
            border-bottom: 3px solid #ff9800;
            padding-bottom: 10px;
        }

        /* Alerts */
        .alert-success {
            background: linear-gradient(45deg, #43a047, #2e7d32);
            color: white;
            border: none;
            box-shadow: 0 4px 8px rgba(67, 160, 71, 0.2);
        }

        .alert-danger {
            background: linear-gradient(45deg, #e53935, #c62828);
            color: white;
            border: none;
            box-shadow: 0 4px 8px rgba(229, 57, 53, 0.2);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar">
                <div class="p-3">
                    <!-- Logo Chirwa Électronique -->
                    <div class="logo-container">
                        @if(file_exists(public_path('images/logo2.png')))
                            <!-- Votre logo logo2.png -->
                            <img src="{{ asset('images/logo2.png') }}" 
                                 alt="Chirwa Électronique" 
                                 class="custom-logo">
                        @elseif(file_exists(public_path('images/logo.png')))
                            <!-- Fallback: logo.png si logo2 n'existe pas -->
                            <img src="{{ asset('images/logo.png') }}" 
                                 alt="Chirwa Électronique" 
                                 class="custom-logo">
                        @else
                            <!-- Fallback: Logo par défaut si aucun fichier n'existe -->
                            <div class="logo-fallback">
                                <div class="logo-icon">
                                    <i class="bi bi-lightning-charge-fill"></i>
                                </div>
                            </div>
                        @endif
                        
                        <div class="company-name">CHIRWA ÉLECTRONIQUE</div>
                       
                    </div>

                    <nav class="nav flex-column">
                        <a href="{{ route('produits.index') }}"
                            class="{{ request()->routeIs('produits.index') ? 'active' : '' }}">
                            <i class="bi bi-grid-fill"></i> Tableau de bord
                        </a>
                        <a href="{{ route('produits.create') }}"
                            class="{{ request()->routeIs('produits.create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle-fill"></i> Ajouter Produit
                        </a>
                        
                        <div class="dropdown mt-3">
                            <a class="dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-download"></i> Exportation
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('export.excel') }}">
                                    <i class="bi bi-file-earmark-excel"></i> Excel
                                </a>
                                <a class="dropdown-item" href="{{ route('export.pdf') }}">
                                    <i class="bi bi-file-earmark-pdf"></i> PDF
                                </a>
                                <a class="dropdown-item" href="{{ route('export.csv') }}">
                                    <i class="bi bi-file-earmark-text"></i> CSV
                                </a>
                            </div>
                        </div>
                        
                        <div class="copyright">
                            <p class="mb-1">Tous les prix en <strong class="text-warning">FDJ</strong></p>
                            <p class="mb-0">&copy; Chirwa Électronique {{ date('Y') }}</p>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>@yield('title')</h2>
                    @yield('actions')
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Confirmation pour les suppressions
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                        e.preventDefault();
                    }
                });
            });
        });
        
        // Vérifier si le logo existe
        document.addEventListener('DOMContentLoaded', function() {
            const logo = document.querySelector('img.custom-logo');
            if (logo) {
                logo.onerror = function() {
                    console.log('Logo non trouvé, utilisation du fallback');
                    this.style.display = 'none';
                    // Ici vous pourriez afficher le fallback dynamiquement
                };
            }
        });
    </script>
    @stack('scripts')
</body>
</html>