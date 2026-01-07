<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BONET - Website untuk UMKM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
        }

        .hero-section {
            background: transparent;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: transparent;
            border-radius: 50%;
            top: -100px;
            right: -100px;
            z-index: 1;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: transparent;
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
            z-index: 1;
        }

        .navbar {
            position: relative;
            z-index: 10;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .navbar-menu {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .navbar-menu a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .navbar-menu a:hover {
            color: #64b5f6;
        }

        .hero-content-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
            padding: 0 40px;
        }

        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            max-width: 1200px;
            width: 100%;
        }

        .hero-card {
            background: transparent;
            padding: 24px 32px;
            border-radius: 12px;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-text h1 {
            font-size: 3.75rem;
            font-weight: 800;
            margin: 0 0 12px 0;
            line-height: 1.05;
            letter-spacing: -0.02em;
            color: rgba(12, 28, 72, 0.98);
            -webkit-text-stroke: 0.5px rgba(255, 255, 255, 0.06);
            text-shadow: 0 8px 30px rgba(3, 12, 45, 0.45);
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.85) 60%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-text p {
            font-size: 1.05rem;
            color: rgba(12, 28, 72, 0.55);
            margin: 0 0 22px 0;
            line-height: 1.6;
        }

        /* center CTA area like attachment */
        .hero-cta {
            display: flex;
            gap: 18px;
            align-items: center;
            justify-content: center;
            margin-top: 18px;
        }

        .cta-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: linear-gradient(90deg, #2f66f6 0%, #5b4ce6 100%);
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
            font-size: 1.05rem;
            box-shadow: 0 18px 40px rgba(59, 76, 230, 0.28);
            border: none;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 26px 60px rgba(59, 76, 230, 0.32);
        }

        .cta-secondary {
            color: rgba(255, 255, 255, 0.92);
            opacity: 0.9;
            font-weight: 600;
            text-decoration: none;
            padding: 14px 20px;
            border-radius: 999px;
        }

        .eyebrow {
            display: inline-block;
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 14px;
            letter-spacing: 0.02em;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 35px;
            background: linear-gradient(135deg, #4f7df5 0%, #3b5cdf 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(79, 125, 245, 0.3);
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(79, 125, 245, 0.4);
            background: linear-gradient(135deg, #5f8dff 0%, #4b6cef 100%);
        }

        .hero-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-image img {
            max-width: 520px;
            height: auto;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .hero-text h1 {
                font-size: 2.1rem;
            }

            .hero-text p {
                font-size: 0.98rem;
            }

            .navbar {
                padding: 12px 18px;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .navbar-menu {
                gap: 12px;
                font-size: 0.9rem;
            }

            .hero-content-wrapper {
                padding: 0 18px;
            }

            .hero-image {
                order: -1;
            }

            .hero-image img {
                max-width: 360px;
            }

            .cta-primary {
                padding: 12px 22px;
                font-size: 0.98rem;
            }
        }
    </style>
</head>

<body>
    <div class="hero-section">
        <nav class="navbar">
            <a href="/" class="navbar-brand">BONET</a>
            <div class="navbar-menu">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>

        <div class="hero-content-wrapper">
            <div class="hero-content">
                <div class="hero-card">
                    <div class="hero-text">
                        <h1>Etalase Ekonomi Lokal</h1>
                        <p style="color: rgba(255,255,255,0.85); margin-top:8px;">Dukung UMKM di lingkungan RT/RW kita.
                        </p>
                        <div class="hero-cta">
                            <a href="{{ route('login') }}" class="cta-primary">+ Daftarkan Usaha</a>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://via.placeholder.com/500x400/1e3a5f/ffffff?text=Kelola+Bisnis+Anda"
                        alt="Website UMKM">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
