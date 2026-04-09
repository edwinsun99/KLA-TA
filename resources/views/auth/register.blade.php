<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Integrated Service Delivery 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-ungu: #6f42c1;
            --primary-ungu-dark: #3f065e;
            --accent-kuning: #ffc107;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-main: #2d3436;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px;
        }

        .container {
            display: flex;
            gap: 25px;
            max-width: 1200px;
            width: 100%;
            margin: auto;
            flex-wrap: wrap;
        }

        .left-section {
            flex: 1.2;
            min-width: 500px;
            background: linear-gradient(160deg, #3f065e 0%, #6f42c1 100%);
            padding: 45px;
            border-radius: 35px;
            box-shadow: 0 20px 40px rgba(63, 6, 94, 0.2);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .welcome-title {
            font-size: 2.4rem;
            font-weight: 800;
            margin-bottom: 25px;
            line-height: 1.1;
        }

        .banner {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 25px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .banner-image img {
            width: 160px;
            border-radius: 18px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .banner-text h2 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--accent-kuning);
        }

        .banner-text p {
            font-size: 0.95rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .middle-content {
            margin: 35px 0;
        }

        .stats-grid {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-box {
            flex: 1;
            background: rgba(255, 255, 255, 0.07);
            padding: 20px 10px;
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            transition: 0.3s;
        }

        .stat-box:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-5px);
        }

        .stat-number {
            display: block;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--accent-kuning);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 600;
            opacity: 0.8;
        }

        .brand-carousel {
            overflow: hidden;
            padding: 15px 0;
            position: relative;
            background: rgba(0,0,0,0.15);
            border-radius: 15px;
        }

        .brand-track {
            display: flex;
            width: calc(120px * 16);
            animation: scroll 25s linear infinite;
            gap: 50px;
            align-items: center;
        }

        .brand-track img {
            height: 25px;
            filter: brightness(0) invert(1);
            opacity: 0.6;
            transition: 0.3s;
        }

        .brand-track img:hover {
            opacity: 1;
            filter: none;
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(calc(-120px * 8)); }
        }

        .main-content-card {
            background: #ffffff;
            padding: 35px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .features {
            display: block;
            margin-bottom: 25px;
        }

        .feature-card {
            background: linear-gradient(to right, #f8f9ff, #ffffff);
            padding: 25px;
            border-radius: 22px;
            text-align: left;
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid #edf2f7;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .feature-card:hover {
            transform: scale(1.02);
            border-color: var(--primary-ungu);
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.15);
        }

        .feature-icon {
            font-size: 45px;
            background: #fff;
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }

        .feature-info {
            flex: 1;
        }

        .feature-title {
            color: var(--primary-ungu-dark);
            font-weight: 800;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .feature-desc {
            color: #718096;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .arrow-icon {
            color: var(--primary-ungu);
            font-size: 1.5rem;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 0.8rem;
            color: #a0aec0;
            padding-top: 20px;
            border-top: 1px solid #edf2f7;
        }

        .right-section {
            width: 420px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid #fff;
            padding: 45px;
            border-radius: 35px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-logo-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .brand-logo {
            max-height: 70px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-title {
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--primary-ungu-dark);
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: #718096;
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #edf2f7;
            border-radius: 18px;
            font-size: 1rem;
            transition: 0.3s;
            background: #f8fafc;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-ungu);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1);
        }

        .login-btn {
            background: linear-gradient(135deg, var(--primary-ungu) 0%, var(--primary-ungu-dark) 100%);
            color: #fff;
            border: none;
            padding: 18px;
            border-radius: 18px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(111, 66, 193, 0.2);
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(111, 66, 193, 0.3);
        }

        .helper-link {
            text-align: center;
            margin-top: 18px;
            font-size: 0.95rem;
        }

        .helper-link a {
            color: var(--primary-ungu);
            font-weight: 700;
            text-decoration: none;
        }

        .helper-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .container { flex-direction: column; }
            .left-section, .right-section { width: 100%; min-width: 100%; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="left-section">
            <div>
                <h1 class="welcome-title">Welcome to KLA Computer <br>Service Center!</h1>

                <div class="banner">
                    <div class="banner-image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT02zEvWRcluqxiLhZkRHu419G9BZ6XpzSr4Q&s" alt="Banner">
                    </div>
                    <div class="banner-text">
                        <h2>Portal Layanan Terintegrasi</h2>
                        <p>Kelola data case dan pantau status perbaikan unit Anda secara real-time melalui sistem yang transparan dan akurat.</p>
                    </div>
                </div>

                <div class="middle-content">
                    <div class="stats-grid">
                        <div class="stat-box">
                            <span class="stat-number">3000+</span>
                            <span class="stat-label">Cases Handled</span>
                        </div>

                        <div class="stat-box">
                            <span class="stat-number">30+</span>
                            <span class="stat-label">Support Brands</span>
                        </div>
                    </div>

                    <div class="brand-carousel">
                        <div class="brand-track">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/HP_logo_2012.svg" alt="HP">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/ASUS_Logo.svg" alt="Asus">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/1/18/Dell_logo_2016.svg" alt="Dell">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/bb/Lenovo_logo_2015.svg" alt="Lenovo">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c9/MSI_Logo.svg" alt="MSI">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/a1/Acer_Logo.svg" alt="Acer">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/HP_logo_2012.svg" alt="HP">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2e/ASUS_Logo.svg" alt="Asus">
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content-card">
                <div class="features">
                    <a href="{{ route('track.form') }}" class="feature-card">
                        <div class="feature-icon">🔍</div>
                        <div class="feature-info">
                            <div class="feature-title">Track My Case</div>
                            <div class="feature-desc">Masukkan nomor case Anda untuk memantau progres perbaikan unit secara langsung.</div>
                        </div>
                        <div class="arrow-icon">➜</div>
                    </a>
                </div>

                <div class="footer">
                    Powered by <strong>KLA Computer</strong> © 2026 | EB Group
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="login-logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="KLA Logo" class="brand-logo">
            </div>

            <div class="login-header">
                <h2 class="login-title">Register</h2>
                <p class="login-subtitle">Silahkan buat akun Anda</p>
            </div>

            @if ($errors->any())
                <div style="background: #fff5f5; color: #e53e3e; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 0.85rem; border: 1px solid #fed7d7;">
                    <ul style="margin: 0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" placeholder="Nama lengkap" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">No. Telp</label>
                    <input type="text" name="phone" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="email@example.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-input" placeholder="Nama akun" value="{{ old('username') }}" required>
                </div>

               <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
                    <span id="togglePassword">🐼</span>
                </div>

                <button type="submit" class="login-btn">
                    REGISTER
                </button>

                <div class="helper-link">
                    Sudah punya akun?
                    <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>

  <script>
        const passwordInput = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.textContent = type === "password" ? "🐼" : "🙈";
        });
    </script>

</body>
</html>