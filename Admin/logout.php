<?php
// MULAI SESSION
session_start();

// HAPUS SEMUA VARIABLE SESSION
session_unset();

// DESTROY SESSION
session_destroy();

// HAPUS SESSION COOKIE
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// REDIRECT KE LOGIN PAGE DENGAN PESAN LOGOUT BERHASIL
header("Location: ../login.php?pesan=logout");
exit();
?>
