<?php
include('../db/db_connection.php');

$successMessage = ""; // Variabel untuk menyimpan pesan sukses
$error = []; // Array untuk menyimpan pesan kesalahan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($email) || empty($username) || empty($password)) {
        $error['general'] = "Semua field harus diisi.";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email tidak valid. Pastikan email Anda mengandung '@'.";
        }
        if (strlen($password) < 8) {
            $error['password'][] = "Password harus minimal 8 karakter.";
        } 
        if (!preg_match('/[A-Z]/', $password)) {
            $error['password'][] = "Password harus mengandung huruf kapital.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $error['password'][] = "Password harus mengandung angka.";
        }

        if (empty($error)) {
            try {
                // Enkripsi password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user into database
                $stmt = $conn->prepare("INSERT INTO tourist (email, username, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $email, $username, $hashed_password);
                $stmt->execute();

                $successMessage = "Registrasi berhasil. Silakan login kembali.";
                $stmt->close();
            } catch (mysqli_sql_exception $e) {
                // Tangkap error jika email sudah ada
                if ($e->getCode() === 1062) {
                    $error['email'] = "Email sudah digunakan. Silakan pilih email lain.";
                } else {
                    $error['general'] = "Terjadi kesalahan saat menyimpan data: " . $e->getMessage();
                }
            }
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <div class="register-container">
        <h3 class="text-center"><strong>Register</strong></h3><br>
        <form id="registerForm" method="post" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <div id="emailError" class="error-message"><?php if (isset($error['email'])) echo $error['email']; ?></div>
            <div id="usernameError" class="error-message"><?php if (isset($error['username'])) echo $error['username']; ?></div>
            <div id="passwordError" class="error-message"><?php if (isset($error['password'])) echo implode('<br>', $error['password']); ?></div>

            <button type="submit">Register</button>
        </form>
        <?php if ($successMessage) echo "<div class='alert alert-success'>$successMessage</div>"; ?>
        <?php if (isset($error['general'])) echo "<div class='alert alert-error'>$error[general]</div>"; ?>
        <br>Sudah memiliki akun? <a href='login.php'>Login di sini</a>
    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            let valid = true;

            // Ambil nilai dari form
            const email = document.getElementById('email').value;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Reset pesan kesalahan
            document.getElementById('emailError').textContent = '';
            document.getElementById('usernameError').textContent = '';
            document.getElementById('passwordError').textContent = '';
            
            // Validasi Email
            if (!email.includes('@')) {
                document.getElementById('emailError').textContent = 'Email tidak valid. Pastikan email Anda mengandung "@".';
                valid = false;
            }

            // Validasi Username (Optional)
            if (username.trim() === '') {
                document.getElementById('usernameError').textContent = 'Username harus diisi.';
                valid = false;
            }

            // Validasi Password
            let passwordErrors = [];
            if (password.length < 8) {
                passwordErrors.push('Password harus minimal 8 karakter.');
            } 
            if (!/[A-Z]/.test(password)) {
                passwordErrors.push('Password harus mengandung huruf kapital.');
            } 
            if (!/[0-9]/.test(password)) {
                passwordErrors.push('Password harus mengandung angka.');
            }
            
            if (passwordErrors.length > 0) {
                document.getElementById('passwordError').innerHTML = passwordErrors.join('<br>');
                valid = false;
            }

            // Jika tidak valid, hentikan pengiriman form
            if (!valid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
