<?php
// SQLite baza fayliga ulanish
try {
    $pdo = new PDO('sqlite:base.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Baza bilan ulanish muvaffaqiyatli!";
} catch (PDOException $e) {
    echo "Ulanishda xatolik: " . $e->getMessage();
}

try {
    $sql = "
    CREATE TABLE IF NOT EXISTS questions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NULL,
        a_variant TEXT NULL,
        b_variant TEXT NULL,
        c_variant TEXT NULL,
        d_variant TEXT NULL,
        correct_answer TEXT NULL,
        key TEXT NULL,
        test_number TEXT NULL
    );";

    // SQL so'rovini bajarish
    $pdo->exec($sql);
    echo "questions jadvali muvaffaqiyatli yaratildi!";
} catch (PDOException $e) {
    echo "Xatolik: " . $e->getMessage();
}
?>
