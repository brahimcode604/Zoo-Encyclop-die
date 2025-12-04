<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Ajouter un nouvel animal</h2>

    <?php
    // ----------- TRAITEMENT DU FORMULAIRE -----------
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Nettoyage des données
        $nom   = htmlspecialchars(trim($_POST['nom_ani']));
        $img   = htmlspecialchars(trim($_POST['url_img']));
        $idhab = intval($_POST['idhab']);

        if (!empty($nom) && !empty($img) && $idhab > 0) {

            $stmt = $conn->prepare("INSERT INTO animal (nom_ani, url_img, idhab) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $nom, $img, $idhab);

            if ($stmt->execute()) {
                echo "<p class='text-green-600 font-bold mb-4'>✔ Animal ajouté avec succès</p>";
            } else {
                echo "<p class='text-red-600 font-bold mb-4'> Erreur SQL : " . $stmt->error . "</p>";
            }

            $stmt->close();
        } else {
            echo "<p class='text-red-600 font-bold mb-4'>⚠ Veuillez remplir tous les champs.</p>";
        }
    }

    // ----------- CHARGER LISTE DES HABITATS -----------
    $habitats = $conn->query("SELECT id, nom_hab FROM habitat ORDER BY nom_hab ASC");
    ?>

    <!-- ----------- FORMULAIRE ----------- -->
    <form method="POST" class="space-y-5">

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Nom de l'animal</label>
            <input type="text" name="nom_ani" 
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                required>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">URL de l'image</label>
            <input type="text" name="url_img" 
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                placeholder="/img_animaux/lion.png" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Habitat</label>
            <select name="idhab" 
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                
                <option value="">-- Choisir un habitat --</option>

                <?php while ($row = $habitats->fetch_assoc()) : ?>
                    <option value="<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['nom_hab']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button 
            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
            Ajouter l'animal
        </button>
    </form>

</div>

</body>
</html>
