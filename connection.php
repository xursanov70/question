<?php
// SQLite baza fayliga ulanish
try {
    $pdo = new PDO('sqlite:base.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Baza bilan ulanish muvaffaqiyatli!";
} catch (PDOException $e) {
    echo "Ulanishda xatolik: " . $e->getMessage();
}