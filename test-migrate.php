<?php
// MySQL ma'lumotlar bazasi ulanish ma'lumotlari
$host = 'mysql-xursanov-test.alwaysdata.net'; // Alwaysdata MySQL host
$username = '392172_jasur'; // Foydalanuvchi nomi
$password = 'jasur2003'; // Foydalanuvchi paroli
$dbname = 'xursanov-test_base'; // Yaratilgan ma'lumotlar bazasining nomi

// MySQL ulanishini o'rnatish
$conn = new mysqli($host, $username, $password, $dbname);

// Ulanishni tekshirish
if ($conn->connect_error) {
    die("Ulanish xatosi: " . $conn->connect_error);
} else {
    echo "Ulanish muvaffaqiyatli!";
}

// Migratsiya (yangi jadval yaratish)
try {
    $sql = "
    CREATE TABLE IF NOT EXISTS questions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        a_variant TEXT,
        b_variant TEXT,
        c_variant TEXT,
        d_variant TEXT,
        correct_answer TEXT,
        `key` VARCHAR(255),
        test_number VARCHAR(255)
    );";

    // SQL so'rovini bajarish
    if ($conn->query($sql) === TRUE) {
        echo "questions jadvali muvaffaqiyatli yaratildi!";
    } else {
        echo "Xatolik: " . $conn->error;
    }
} catch (Exception $e) {
    echo "Xatolik: " . $e->getMessage();
}

// Baza bilan ulanishni yopish
$conn->close();
?>



