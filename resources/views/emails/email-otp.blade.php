<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - InfoHilang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .header {
            background-color: #2563eb; /* blue-600 */
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .logo span {
            color: #93c5fd; /* blue-300 */
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
            margin-top: 0;
        }
        .text {
            font-size: 16px;
            line-height: 1.6;
            color: #475569;
            margin-bottom: 25px;
        }
        .otp-container {
            text-align: center;
            margin: 35px 0;
        }
        .otp-box {
            display: inline-block;
            background-color: #eff6ff; /* blue-50 */
            border: 2px dashed #93c5fd; /* blue-300 */
            color: #1e40af; /* blue-800 */
            font-size: 36px;
            font-weight: 800;
            letter-spacing: 12px;
            padding: 15px 20px 15px 32px;
            border-radius: 12px;
        }
        .info-box {
            background-color: #fff7ed; /* orange-50 */
            border-left: 4px solid #f97316; /* orange-500 */
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 0 8px 8px 0;
        }
        .info-text {
            font-size: 14px;
            color: #c2410c; /* orange-700 */
            margin: 0;
            line-height: 1.5;
        }
        .footer {
            background-color: #0f172a; /* slate-900 */
            padding: 25px 30px;
            text-align: center;
        }
        .footer-text {
            font-size: 13px;
            color: #94a3b8; /* slate-400 */
            margin: 0;
            line-height: 1.5;
        }
        .footer-link {
            color: #60a5fa; /* blue-400 */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <!-- Header -->
            <div class="header">
                <a href="{{ config('app.url') }}" class="logo">
                    Info<span>Hilang</span>
                </a>
            </div>

            <!-- Content -->
            <div class="content">
                <h1 class="greeting">Halo, {{ $user->fullname ?? ($user->username ?? 'Pengguna') }}!</h1>
                <p class="text">
                    Terima kasih telah bergabung dengan komunitas <strong>InfoHilang</strong>. Untuk menyelesaikan proses pendaftaran dan memverifikasi alamat email Anda, silakan gunakan kode sandi sekali pakai (OTP) di bawah ini.
                </p>

                <div class="otp-container">
                    <div class="otp-box">{{ $otp }}</div>
                </div>

                <div class="info-box">
                    <p class="info-text">
                        <strong>Penting:</strong> Kode ini hanya berlaku selama <strong>{{ $ttl }} menit</strong>. Demi keamanan, jangan pernah membagikan kode ini kepada siapa pun, termasuk pihak yang mengaku dari tim InfoHilang.
                    </p>
                </div>

                <p class="text" style="font-size: 14px; color: #64748b; margin-bottom: 0;">
                    Jika Anda tidak merasa mendaftar di InfoHilang, Anda dapat mengabaikan email ini dengan aman.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p class="footer-text">
                    &copy; {{ date('Y') }} InfoHilang Community. Membantu menemukan yang berharga.<br>
                    <a href="{{ config('app.url') }}" class="footer-link">Kunjungi Website Kami</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
