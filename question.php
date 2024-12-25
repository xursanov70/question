<?php
// MySQL ma'lumotlar bazasi ulanish ma'lumotlari
$host = 'mysql-xursanov-test.alwaysdata.net'; // Alwaysdata MySQL host
$username = '392172_jasur'; // Foydalanuvchi nomi
$password = 'jasur2003'; // Foydalanuvchi paroli
$dbname = 'xursanov-test_base'; // Yaratilgan ma'lumotlar bazasining nomi

// MySQL ulanishini o'rnatish
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Baza bilan ulanishda xatolik: " . $e->getMessage();
    exit;
}

// Savollarni olish
$query = "SELECT * FROM questions"; // Faqat aktiv savollarni olish
$stmt = $pdo->query($query);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Javoblarni olish
$correctAnswers = [];
foreach ($questions as $question) {
    $correctAnswers[$question['id']] = $question['correct_answer'];
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Savollar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white dark:bg-black text-black dark:text-white min-h-screen py-12 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="fixed top-4 right-4 flex space-x-2">
        <button onclick="setTheme('light')" class="p-2 rounded-full bg-gray-200 dark:bg-gray-800 text-black dark:text-white">
            <i data-lucide="sun" class="w-6 h-6"></i>
        </button>
        <button onclick="setTheme('dark')" class="p-2 rounded-full bg-gray-200 dark:bg-gray-800 text-black dark:text-white">
            <i data-lucide="moon" class="w-6 h-6"></i>
        </button>
    </div>
    <div class="max-w-3xl mx-auto space-y-8">
        <h2 class="text-4xl font-extrabold text-center mb-8 text-black dark:text-white">Test Savollar</h2>
        <form id="quizForm">
            <?php foreach ($questions as $index => $question): ?>
                <div class="bg-gray-100 dark:bg-gray-900 bg-opacity-50 backdrop-filter backdrop-blur-lg rounded-xl shadow-lg p-6 space-y-4">
                    <h3 class="text-xl font-bold text-black dark:text-white"><?= $index + 1; ?>. <?= htmlspecialchars($question['title']); ?></h3>
                    <div class="space-y-2">
                        <?php foreach (['a', 'b', 'c', 'd'] as $variant): ?>
                            <label class="flex items-center space-x-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-800 transition duration-150 ease-in-out">
                                <input type="radio" name="question_<?= $question['id']; ?>" value="<?= $variant; ?>" class="form-radio h-5 w-5 text-pink-600">
                                <span class="text-gray-700 dark:text-gray-300"><?= htmlspecialchars($question[$variant . '_variant']); ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
        <div class="flex justify-center mt-8">
            <button onclick="showResults()" class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                Testni yakunlash
            </button>
        </div>
    </div>

    <script>
        const correctAnswers = <?= json_encode($correctAnswers); ?>;
        function showResults() {
            const form = document.getElementById('quizForm');
            const formData = new FormData(form);
            let totalQuestions = Object.keys(correctAnswers).length;
            let correctCount = 0;

            formData.forEach((value, key) => {
                const questionId = key.split('_')[1];
                if (correctAnswers[questionId] === value) {
                    correctCount++;
                }
            });

            alert(`Jami savollar: ${totalQuestions}\nTo'g'ri javoblar: ${correctCount}\nNoto'g'ri javoblar: ${totalQuestions - correctCount}`);
        }

        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        // Lucide ikonkalarini o'rnatish
        lucide.createIcons();
    </script>
</body>
</html>
