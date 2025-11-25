<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --info-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --light-bg: #f8f9fa;
            --dark-bg: #121826;
        }
        
        body {
            background: var(--light-bg);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .hero-section {
            background: var(--primary-gradient);
            color: white;
            padding: 6rem 0 4rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.05"><polygon points="0,100 1000,0 1000,100"/></svg>');
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .rounded-4 {
            border-radius: 1.5rem !important;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            background: rgba(255, 255, 255, 1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            background: var(--primary-gradient);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
        }
        
        .stats-card.category::before { background: var(--primary-gradient); }
        .stats-card.warehouse::before { background: var(--secondary-gradient); }
        .stats-card.product::before { background: var(--success-gradient); }
        .stats-card.stock::before { background: var(--warning-gradient); }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            display: block;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stats-label {
            font-size: 1rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 3rem;
            font-weight: 700;
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
        
        .btn-hover {
            transition: all 0.3s ease;
        }
        
        .btn-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .gradient-bg {
            background: var(--primary-gradient);
        }
        
        .feature-content {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover .feature-content {
            transform: translateY(-5px);
        }
        
        .section-padding {
            padding: 5rem 0;
        }
        
        @media (max-width: 768px) {
            .hero-section {
                padding: 4rem 0 2rem;
            }
            
            .stats-card {
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-2 fw-bold mb-3">
                        <i class="fas fa-cubes me-3"></i>Sistem Manajemen Produk
                    </h1>
                    <p class="lead mb-4 fs-3">Sistem komprehensif untuk mengelola produk, kategori, gudang, dan stok dengan antarmuka yang intuitif</p>
                    <div class="d-flex justify-content-center gap-4 flex-wrap">
                        <a href="{{ route('products.index') }}" class="btn btn-light btn-hover btn-lg px-5 py-3 fw-bold fs-5">
                            <i class="fas fa-box-open me-2"></i>Kelola Produk
                        </a>
                        <a href="{{ route('stock.index') }}" class="btn btn-outline-light btn-hover btn-lg px-5 py-3 fw-bold fs-5">
                            <i class="fas fa-exchange-alt me-2"></i>Manajemen Stok
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mb-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Fitur Utama Sistem</h2>
            <p class="text-muted fs-5">Kelola seluruh aspek bisnis Anda dalam satu platform terpadu</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('categories.index') }}" class="text-decoration-none">
                    <div class="card feature-card h-100">
                        <div class="text-center p-4">
                            <div class="feature-icon primary-bg">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h5 class="card-title fw-bold">Kategori Produk</h5>
                            <p class="card-text text-muted">Kelola kategori produk seperti Elektronik, Furnitur, dan lainnya</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('warehouses.index') }}" class="text-decoration-none">
                    <div class="card feature-card h-100">
                        <div class="text-center p-4">
                            <div class="feature-icon success-bg">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <h5 class="card-title fw-bold">Gudang</h5>
                            <p class="card-text text-muted">Kelola gudang seperti Gudang Makassar, Gudang Gowa</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('products.index') }}" class="text-decoration-none">
                    <div class="card feature-card h-100">
                        <div class="text-center p-4">
                            <div class="feature-icon info-bg">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h5 class="card-title fw-bold">Produk</h5>
                            <p class="card-text text-muted">Kelola produk lengkap dengan detail produk dan harga</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('stock.index') }}" class="text-decoration-none">
                    <div class="card feature-card h-100">
                        <div class="text-center p-4">
                            <div class="feature-icon warning-bg">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <h5 class="card-title fw-bold">Stok</h5>
                            <p class="card-text text-muted">Lihat dan transfer stok antar gudang dengan validasi ketat</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="container section-padding">
        <div class="text-center mb-5">
            <h2 class="section-title display-6">Statistik Sistem</h2>
            <p class="text-muted fs-4">Informasi terkini dari sistem manajemen produk</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="stats-card category">
                    <i class="fas fa-tags fa-3x mb-3"></i>
                    <span class="stats-number" id="categoryCount">0</span>
                    <span class="stats-label">Kategori</span>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card warehouse">
                    <i class="fas fa-warehouse fa-3x mb-3"></i>
                    <span class="stats-number" id="warehouseCount">0</span>
                    <span class="stats-label">Gudang</span>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card product">
                    <i class="fas fa-box fa-3x mb-3"></i>
                    <span class="stats-number" id="productCount">0</span>
                    <span class="stats-label">Produk</span>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stats-card stock">
                    <i class="fas fa-chart-line fa-3x mb-3"></i>
                    <span class="stats-number" id="stockCount">0</span>
                    <span class="stats-label">Total Stok</span>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info Section -->
    <div class="container mb-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Deskripsi Sistem</h2>
            <p class="text-muted fs-5">Fitur lengkap untuk manajemen produk yang efisien</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-list text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Manajemen Kategori</h5>
                                        <p class="text-muted mb-0">Pengelolaan jenis produk (Elektronik, Furnitur, dll)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-warehouse text-success fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Manajemen Gudang</h5>
                                        <p class="text-muted mb-0">Pengelolaan lokasi penyimpanan (Gudang Makassar, Gudang Gowa)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-box text-info fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Manajemen Produk</h5>
                                        <p class="text-muted mb-0">Pengelolaan produk lengkap (nama, harga, kategori, berat, ukuran)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-start">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-exchange-alt text-warning fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold">Manajemen Stok</h5>
                                        <p class="text-muted mb-0">Fungsi transfer stok antar gudang dengan validasi ketat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0">Sistem Manajemen Produk &copy; {{ date('Y') }} - Tugas 9</p>
                    <p class="mb-0 text-muted small">Membantu bisnis Anda mengelola produk dengan lebih efisien</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple animation for stats - in real app you would fetch these from the backend
        document.addEventListener('DOMContentLoaded', function() {
            // Animate the stats numbers
            animateValue('categoryCount', 0, 10, 1000);
            animateValue('warehouseCount', 0, 5, 1000);
            animateValue('productCount', 0, 20, 1000);
            animateValue('stockCount', 0, 100, 1000);
        });
        
        function animateValue(id, start, end, duration) {
            let obj = document.getElementById(id);
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerText = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
    </script>
</body>
</html>