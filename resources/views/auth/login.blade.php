<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Absensi QR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            background-color: #0f0b1e;
            background-image:
                radial-gradient(circle at 15% 20%, rgba(236,72,153,0.35) 0%, transparent 45%),
                radial-gradient(circle at 85% 15%, rgba(99,102,241,0.4) 0%, transparent 45%),
                radial-gradient(circle at 20% 85%, rgba(34,211,238,0.3) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(168,85,247,0.35) 0%, transparent 45%);
            position: relative;
            overflow: hidden;
        }
        .login-card {
            background: rgba(255,255,255,0.97);
            width: 100%;
            max-width: 380px;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.45);
            overflow: hidden;
            z-index: 1;
            backdrop-filter: blur(10px);
        }
        .login-card .card-header {
            background: linear-gradient(135deg, #1e1b4b, #4c1d95);
            color: #fff;
            text-align: center;
            padding: 2rem 1.5rem 1.6rem;
        }
        .login-card .card-header h1 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
        }
        .login-card .card-header p {
            color: #c4b5fd;
            font-size: 13px;
            margin: 4px 0 0;
        }
        .login-card .card-body {
            padding: 2rem 1.75rem;
        }
        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .field input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            background: #f8fafc;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field input:focus {
            border-color: #7c3aed;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(124,58,237,0.12);
        }
        .remember-row {
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 22px;
            font-size: 13px;
            color: #475569;
        }
        .remember-row input { accent-color: #7c3aed; }
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #7c3aed, #6366f1);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(124,58,237,0.4);
            transition: filter 0.15s, transform 0.1s;
        }
        .btn-submit:hover { filter: brightness(1.08); }
        .btn-submit:active { transform: scale(0.98); }
        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="card-header">
            <h1>Absensi QR</h1>
            <p>Login Admin / Guru</p>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@sekolah.test">
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <button class="btn-submit">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>