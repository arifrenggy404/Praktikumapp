<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIM {{ $setting->singkatan_gereja ?? 'GKS Kandara' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            margin-top: 10%;
        }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0 rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <h3 class="card-title text-center mb-2 fw-bold text-primary">SIM {{ strtoupper($setting->singkatan_gereja ?? 'GKS KANDARA') }}</h3>
                    <p class="text-center text-muted mb-4">{{ $setting->nama_gereja ?? 'Sistem Informasi Manajemen Jemaat & Pelayanan' }}</p>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ url('/login') }}" method="POST">
                        @csrf <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                   id="username" name="username" placeholder="Username"
                                   value="{{ old('username') }}" required autofocus>
                            <label for="username">Username Admin</label>
                            </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" 
                                   id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-login text-uppercase fw-bold p-2" type="submit">
                                Masuk Sistem
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <a class="small text-decoration-none" href="{{ url('/') }}">
                            &larr; Kembali ke Halaman Publik Jemaat
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>