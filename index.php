<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Save Bookmarks</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="PGX">
<link rel="stylesheet" href="./src/style.css">
<style>
.edit-inputs {
display: none;
}
</style>
</head>
<body>
<center>
<h2 class="title">Save Bookmarks</h2>
<div class="add">
<div class="mostrar">
<form method="post">
<input class="i1" name="name" type="text" autocomplete="off" placeholder="Nombre" required>
<input class="i2" name="link" type="text" autocomplete="off" placeholder="Link" required>
<input class="btn1" type="submit" value="GUARDAR">
</form>
<form method="post" style="margin-top:20px;">
<input class="i1" name="searchname" type="text" autocomplete="off" placeholder="Buscar por Nombre" required>
<input class="btn1" type="submit" value="BUSCAR">
</form>
<?php
$host = "localhost"; 
$user = "root";
$pass = "";
$dbname = "svbookmarks"; 
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
die("Conexión fallida: " . $conn->connect_error);
}
if (!empty($_POST['link']) && !empty($_POST['name']) && !isset($_POST['update'])) {
$link = $_POST['link'];
$nombre = $_POST['name'];
$sql = "INSERT INTO marcadores (NOMBRE, LINKS) VALUES ('$nombre', '$link')";
if ($conn->query($sql) === TRUE) {
echo "<br>Marcador Guardado Exitosamente.";
} else {
echo "<br>Error al guardar el marcador: " . $conn->error;
}
}
if (isset($_POST['searchname']) && !empty($_POST['searchname'])) {
$searchname = $_POST['searchname'];
$sql = "SELECT ID, NOMBRE, LINKS FROM marcadores WHERE NOMBRE LIKE '%$searchname%'";
} else {
$sql = "SELECT ID, NOMBRE, LINKS FROM marcadores";
}
if (isset($_POST['update'])) {
$id = $_POST['id'];
$nombre = $_POST['name'];
$link = $_POST['link'];
$sqlUpdate = "UPDATE marcadores SET NOMBRE='$nombre', LINKS='$link' WHERE ID='$id'";
if ($conn->query($sqlUpdate) === TRUE) {
echo "<br>Marcador actualizado exitosamente.";
} else {
echo "<br>Error al actualizar el marcador: " . $conn->error;
}
}
if (isset($_POST['delete'])) {
$id = $_POST['id'];
$sqlDelete = "DELETE FROM marcadores WHERE ID='$id'";
if ($conn->query($sqlDelete) === TRUE) {
echo "<br>Marcador eliminado exitosamente.";
} else {
echo "<br>Error al eliminar el marcador: " . $conn->error;
}
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
echo "<P><table style=\"width:90%;\" border='1'>
<tr>
<th>NRO</th>
<th>Nombre</th>
<th>Enlaces</th>
<th>Acciones</th>
</tr>";
$n = 0;
while ($row = $result->fetch_assoc()) {
$n++;
echo "<tr>
<td class=\"nro\">" . $n . "</td>
<td class=\"nro\">" . htmlspecialchars($row["NOMBRE"]) . "</td>
<td class=\"nro\"><a class=\"links\" target=\"_blank\" href='" . htmlspecialchars($row["LINKS"]) . "'>" . htmlspecialchars($row["LINKS"]) . "</a></td>
<td class=\"nro\">
<form method='post' style='display:inline;'>
<input type='hidden' name='id' value='" . $row["ID"] . "'>
<input type='submit' class='delete' name='delete' value='Eliminar'>
</form>
<button class=\"editar\" onclick=\"editBookmark(" . $row["ID"] . ", '" . htmlspecialchars($row["NOMBRE"]) . "', '" . htmlspecialchars($row["LINKS"]) . "')\">Editar</button>
<div class='edit-inputs' id='edit-" . $row["ID"] . "'>
<form method='post' style='display:inline;'>
<input type='hidden' name='id' value='" . $row["ID"] . "'>
<input class='n1' type='text' name='name' required>
<input class='l1' type='text' name='link' required><p>
<input class='gcamb' type='submit' name='update' value='Guardar Cambios'>
</form>
</div>
</td>
</tr>";
}
echo "</table>";
} else {
echo "<p class=\"nf\">No se encontraron marcadores.</p>";
}
$conn->close();
?>
</div>
</div>
</center>
<script>
function editBookmark(id, name, link) {
var editDiv = document.getElementById('edit-' + id);
if (editDiv.style.display === "none" || editDiv.style.display === "") {
editDiv.style.display = "block"; 
} else {
editDiv.style.display = "none"; 
}
}
</script>
</body>
</html>
