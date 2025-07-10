<?php

// Fungsi untuk membuat password bcrypt
function generateBcryptPassword($plainPassword, $cost = 10) {
    // Parameter $cost menentukan kompleksitas hash (default = 10)
    // Nilai yang lebih tinggi = lebih aman tapi lebih lambat
    
    // Buat hash bcrypt dengan password_hash()
    $options = [
        'cost' => $cost
    ];
    
    $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT, $options);
    
    return $hashedPassword;
}

// Contoh penggunaan
$password = "password";
$hashedPassword = generateBcryptPassword($password);

echo "Password asli: " . $password . "\n";
echo "Password bcrypt: " . $hashedPassword . "\n";

// Untuk memverifikasi password
$isValid = password_verify($password, $hashedPassword);
echo "Verifikasi password: " . ($isValid ? "Valid" : "Tidak valid") . "\n";
?>