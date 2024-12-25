<?php
require 'vendor/autoload.php'; // Composer orqali o'rnatilgan kutubxonani chaqirish

use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    // SQLite baza fayliga ulanish
    $pdo = new PDO('sqlite:base.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Baza bilan ulanishda xatolik: " . $e->getMessage();
    exit;
}

if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['excel_file']['tmp_name'];

    // Excel faylini o'qish
    $spreadsheet = IOFactory::load($fileTmpPath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray(); // Barcha satrlarni o'qish

    // Birinchi qatorni (ustun nomlari) o'tkazib yuborish
    array_shift($rows);

    // Excel faylidan olingan ma'lumotlarni bazaga kiritish
    $stmt = $pdo->prepare("INSERT INTO questions (title, a_variant, b_variant, c_variant, d_variant, correct_answer, test_number, key) 
                           VALUES (:title, :a_variant, :b_variant, :c_variant, :d_variant, :correct_answer, :test_number, :key)");

    foreach ($rows as $row) {
        if ($row[0] && $row[1] && $row[2] && $row[3] && $row[4] && $row[5]) {
            $stmt->execute([
                ':title' => $row[0],  // Savol
                ':a_variant' => $row[1],  // Variant A
                ':b_variant' => $row[2],  // Variant B
                ':c_variant' => $row[3],  // Variant C
                ':d_variant' => $row[4],  // Variant D
                ':correct_answer' => $row[5],
                ':test_number' => $row[6],
                ':key' => $row[7]
            ]);
        }
    }

    echo "Excel faylidan ma'lumotlar bazaga muvaffaqiyatli kiritildi!";
} else {
    echo "Excel fayli yuklanmadi yoki xato!";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Faylini Yuklash</title>
</head>
<body>

    <h1>Excel Faylini SQLite Bazasiga Yuklash</h1>
    
    <form action="excel.php" method="POST" enctype="multipart/form-data">
        <label for="excel_file">Excel faylini tanlang:</label>
        <input type="file" name="excel_file" id="excel_file" accept=".xlsx, .xls, .csv" required>
        <button type="submit">Yuklash</button>
    </form>

</body>
</html>
