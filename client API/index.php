<?php
$apiUrl = 'https://st1738846851.splsites.nl/api.php';
$error = '';
$message = '';

// PRODUCT TOEVOEGEN (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['naam'], $_POST['prijs'])) {

    $product = [
        'naam' => $_POST['naam'],
        'prijs' => (float) $_POST['prijs']
    ];

    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($product),
    ]);

    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code !== 200 && $code !== 201) {
        $error = 'Product toevoegen mislukt';
    } else {
        $message = 'Product toegevoegd!';
    }
}

// ===============================
// PRODUCT VERWIJDEREN (DELETE) - EXTRA
// ===============================
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $ch = curl_init($apiUrl . '/' . $id);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
    ]);

    curl_exec($ch);
    curl_close($ch);
}

// PRODUCTEN OPHALEN (GET)
$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
?>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <title>Producten API</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px }
    form, table { background:#fff; padding:15px; border-radius:8px; margin-bottom:20px }
    input, button { padding:6px }
    table { border-collapse: collapse; width:100% }
    th, td { border:1px solid #ccc; padding:8px; text-align:left }
    th { background:#eee }
    .error { color:red }
    .success { color:green }
  </style>
</head>
<body>

<h1>Productbeheer (API)</h1>

<?php if ($error): ?>
  <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($message): ?>
  <p class="success"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<h2>Product toevoegen</h2>
<form method="post">
  <label>Naam:</label><br>
  <input type="text" name="naam" required><br><br>

  <label>Prijs (€):</label><br>
  <input type="number" step="0.01" name="prijs" required><br><br>

  <button type="submit">Opslaan</button>
</form>

<h2>Producten</h2>
<table>
  <tr>
    <th>ID</th>
    <th>Naam</th>
    <th>Prijs (€)</th>
    <th>Actie</th>
  </tr>

  <?php if (is_array($data)): ?>
    <?php foreach ($data as $product): ?>
      <tr>
        <td><?= htmlspecialchars($product['id']) ?></td>
        <td><?= htmlspecialchars($product['naam']) ?></td>
        <td><?= htmlspecialchars($product['prijs']) ?></td>
        <td>
          <a href="?delete=<?= (int)$product['id'] ?>" onclick="return confirm('Weet je het zeker?')">
            Verwijderen
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr><td colspan="4">Geen producten gevonden</td></tr>
  <?php endif; ?>
</table>

</body>
</html>
