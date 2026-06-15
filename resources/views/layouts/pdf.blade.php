<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10px;
            color: #666;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mt-4 { margin-top: 20px; }
        .signature-container {
            margin-top: 50px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Gereja Kristen Sumba (GKS) Kandara</h1>
        <p>Alamat: Jl. Raya Kandara No. 123, Sumba Timur</p>
        <p>Telepon: (0387) 123456 | Email: gkskandara@gmail.com</p>
    </div>

    <div class="content">
        <h2 style="text-align: center; font-size: 16px; margin-bottom: 20px;">@yield('title')</h2>
        @yield('content')
    </div>

    <div class="footer">
        Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }} | Halaman <span class="page-number"></span>
    </div>

    <div class="signature-container">
        <div class="signature-box">
            <p>Kandara, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Sekretaris Jemaat,</p>
            <div class="signature-space"></div>
            <p><strong>( ____________________ )</strong></p>
        </div>
    </div>
</body>
</html>
