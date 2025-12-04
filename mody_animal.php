<?php
include "includes/db.php";
include "includes/header.php";

// Vérifier si un ID est passé via POST ou GET
$id = 0;
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}

if ($id <= 0) {
    header("Location: index.php"); // Retour à la liste si ID invalide
    exit();
}


$test=false;
// ----------- TRAITEMENT DU FORMULAIRE ----------- //
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom_ani = htmlspecialchars(trim($_POST['nom_ani']));
    $url_img = htmlspecialchars(trim($_POST['url_img']));
    $idhab   = intval($_POST['idhab']);

    if (!empty($nom_ani) && !empty($url_img) && $idhab > 0) {
        $stmt = $conn->prepare("UPDATE animal SET nom_ani=?, url_img=?, idhab=? WHERE id=?");
        $stmt->bind_param("ssii", $nom_ani, $url_img, $idhab, $id);

        if ($stmt->execute()) {
            header("Location: index.php?update=1"); // Redirection après modification
            exit();
        } else {
            echo "<p class='text-red-600 font-bold mb-4'>Erreur SQL : ".$stmt->error."</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='text-red-600 font-bold mb-4'>⚠ Veuillez remplir tous les champs.</p>";
    }
}

// ----------- Récupérer les informations actuelles de l'animal ----------- //
$stmt = $conn->prepare("SELECT * FROM animal WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$animal = $result->fetch_assoc();
$stmt->close();
 
$habitats = $conn->query("SELECT id, nom_hab FROM habitat ORDER BY nom_hab ASC");
?>




<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Modifier un animal</h2>

    <form method="POST" class="space-y-5">
        <input type="hidden" name="id" value="<?= $animal['id'] ?>">

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nom de l'animal</label>
            <input type="text" name="nom_ani" class="w-full p-3 border rounded-lg"
                   value="<?= htmlspecialchars($animal['nom_ani']) ?>" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">URL de l'image</label>
            <input type="text" name="url_img" class="w-full p-3 border rounded-lg"
                   value="<?= htmlspecialchars($animal['url_img']) ?>" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Habitat</label>
            <select name="idhab" class="w-full p-3 border rounded-lg" required>
                <option value="">-- Choisir un habitat --</option>
                <?php while($row = $habitats->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $animal['idhab']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['nom_hab']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Enregistrer les modifications

          <?=  $test=true;?>
        </button>
    </form>
</div>
