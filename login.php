<!DOCTYPE html>
<html lang="id">
<head>
  <!--META TAG DAN CACHE CONTROL-->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Login - Sistem Perizinan Siswa</title>

  <!--LINK CSS BOOTSTRAP DAN BOOTSTRAP ICONS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

  <!--STYLING LOGIN PAGE-->
  <style>
    :root {
      --primary-color: #2563eb;
      --secondary-color: #1e40af;
    }
    body {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-container {
      width: 100%;
      max-width: 420px;
    }
    .card {
      border: none;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      border-radius: 15px;
    }
    .card-header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
      border: none;
      border-radius: 15px 15px 0 0;
      padding: 2rem;
      text-align: center;
    }
    .card-header h3 {
      margin: 0;
      font-weight: 700;
    }
    .card-header p {
      margin: 0.5rem 0 0 0;
      opacity: 0.9;
      font-size: 0.95rem;
    }
    .card-body {
      padding: 2.5rem;
    }
    .form-control {
      border-radius: 8px;
      border: 1px solid #e5e7eb;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .form-label {
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
    }
    .btn-login {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      border: none;
      border-radius: 8px;
      padding: 0.75rem;
      font-weight: 600;
      transition: all 0.3s ease;
      color: white;
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
      color: white;
    }
    .alert {
      border-radius: 8px;
      border: none;
      margin-bottom: 1.5rem;
    }
    .alert-success {
      background-color: #d1fae5;
      color: #065f46;
    }
    .alert-danger {
      background-color: #fee2e2;
      color: #991b1b;
    }
    .input-group {
      position: relative;
    }
    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--primary-color);
    }
    .form-control-with-icon {
      padding-left: 2.5rem;
    }
  </style>
</head>
<body>
  <!-- CONTAINER LOGIN -->
  <div class="login-container">
    <div class="card">
      <!-- HEADER CARD -->
      <div class="card-header">
        <h3><i class="bi bi-building"></i> SiPena</h3>
        <p>Sistem Perizinan Siswa</p>
      </div>

      <!-- BODY CARD DENGAN FORM LOGIN -->
      <div class="card-body">
        <!-- LOGIC PESAN ALERT -->
        <?php
        $pesan = $_GET['pesan'] ?? '';

        if ($pesan == 'logout') { ?>
        <div class="alert alert-success" role="alert">
          <i class="bi bi-check-circle"></i> <strong>Berhasil!</strong> Anda telah logout dari sistem.
        </div>
        <?php }
        elseif ($pesan == 'gagal') { ?>
        <div class="alert alert-danger" role="alert">
          <i class="bi bi-exclamation-circle"></i> <strong>Login Gagal!</strong> Username atau password tidak sesuai.
        </div>
        <?php }
        elseif ($pesan == 'belum_login') { ?>
        <div class="alert alert-danger" role="alert">
          <i class="bi bi-exclamation-triangle"></i> <strong>Akses Ditolak!</strong> Silakan login terlebih dahulu.
        </div>
        <?php } ?>

        <!--FORM LOGIN-->
        <form action="cek_login.php" method="POST">
          <!--INPUT USERNAME-->
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
              <span class="input-icon"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control form-control-with-icon" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>
          </div>

          <!--INPUT PASSWORD-->
          <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-icon"><i class="bi bi-lock"></i></span>
              <input type="password" class="form-control form-control-with-icon" id="password" name="password" placeholder="Masukkan password" required>
            </div>
          </div>

          <!--TOMBOL LOGIN--> 
          <button type="submit" class="btn btn-login w-100">
            <i class="bi bi-box-arrow-in-right"></i> Login
          </button>
        </form>

        <!--DIVIDER-->
        <hr class="my-3">

        <!--INFORMASI BANTUAN-->    
        <p class="text-center text-muted" style="font-size: 0.85rem;">
          <i class="bi bi-info-circle"></i> Hubungi administrator jika mengalami kendala login
        </p>
      </div>
    </div>
  </div>

  <!--LINK SCRIPT BOOTSTRAP-->    
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>