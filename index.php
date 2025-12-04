<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>

<?php   
 

$habitats = $conn->query("SELECT id, nom_hab FROM habitat ORDER BY nom_hab ASC"); 
?>

<form method="POST" class="space-y-5">
    <h2 class="text-3xl font-bold mb-4">Filtrer les animaux</h2>

    <div>
        <label class="block mb-1 font-semibold text-gray-700">Habitat</label>
        <select name="idhab" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">

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
        Chercher
    </button>
</form>

<?php  
// Construire la requête selon filtre
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $idhab = intval($_POST['idhab']);

    if ($idhab > 0) {
        $sql = "SELECT a.id, a.nom_ani, a.url_img, h.nom_hab
                FROM animal a
                JOIN habitat h ON a.idhab = h.id
                WHERE h.id = $idhab";
    } else {
        $sql = "SELECT a.id, a.nom_ani, a.url_img, h.nom_hab
                FROM animal a
                JOIN habitat h ON a.idhab = h.id";
    }

} else {

    $sql = "SELECT a.id, a.nom_ani, a.url_img, h.nom_hab
            FROM animal a
            JOIN habitat h ON a.idhab = h.id";
}
?>

<h2 class="text-3xl font-bold mb-4 mt-10">Liste des animaux</h2>

<?php
// Message si suppression OK
if (isset($_GET['delete']) == 1) {
    echo "<p class='text-green-600 font-bold mb-4'>✔ Animal supprimé avec succès</p>";
}
?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

<?php
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

    echo "
    <div class='bg-white shadow-lg p-4 rounded-xl'>
        <img src='{$row['url_img']}' class='w-full h-48 object-cover rounded-lg'>
        <h3 class='text-xl font-bold mt-3'>{$row['nom_ani']}</h3>
        <p class='text-gray-600'>Habitat : {$row['nom_hab']}</p>

<div   class='flex gap-4' >
  <form action='delete_animal.php' method='POST' class='mt-3'>
    <input type='hidden' name='id' value='{$row['id']}'>
    
    <button type='submit'
        class='bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition'>
        Supprimer
    </button>
</form>


 <form action='mody_animal.php' method='GET' class='mt-3'>
    <input type='hidden' name='id' value='{$row['id']}'>
    
    <button type='submit'
        class=' bg-green-600 text-white px-4 py-2 rounded-lg font-semibol  transition'>
        modifire
    </button>
</form>

</div>

    </div>";
}
?>

</div>

</body>
</html>
