<?php
// 1. Connect to MySQL using PDO.
// Replace the placeholders with your own credentials.

$host = 'mi-linux.wlv.ac.uk';
$dbname = 'db2410675';
$username = '2410675';
$password = 'PROXY@68#[68]';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );

    // 2. Retrieve the books.
    $stmt = $pdo->query(
        "SELECT Book_name, Genre, Price, Date_of_release
         FROM books
         ORDER BY Book_id"
    );

    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Unable to retrieve the books. Please try again later.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Library</title>
</head>
<body>

<h1>Books Library</h1>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Book name</th>
            <th>Genre</th>
            <th>Price</th>
            <th>Date of release</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td>
                    <?= htmlspecialchars($book['Book_name'], ENT_QUOTES, 'UTF-8') ?>
                </td>
                <td>
                    <?= htmlspecialchars($book['Genre'], ENT_QUOTES, 'UTF-8') ?>
                </td>
                <td>
                    £<?= number_format((float) $book['Price'], 2) ?>
                </td>
                <td>
                    <?= date(
                        'd/m/Y',
                        strtotime($book['Date_of_release'])
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>