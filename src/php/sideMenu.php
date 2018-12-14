<?php
function checkURI($current) {
    if ($_SERVER['REQUEST_URI'] === $current) {
        echo " activeMenu";
    }
}
?>
<style>
.activeMenu {
	background-color: #2ECC71;
	color: #fafafa;
}
</style>
<div class="sideMenu col2 colt2 colm12 floatLeft fixed">
    <a href="http://localhost:3000/"><img class="logo" src="./images/logo.png"></a>
    <a class="sideMenuButton" href="http://localhost:3000/athlete">Athlètes</a>
    <a class="sideMenuButton" href="http://localhost:3000/group">Groupes</a>
    <a class="sideMenuButton" href="http://localhost:3000/evaluation">Évaluations</a>
    <a class="sideMenuButton<?php checkURI("/manageUsers.php") ?>"
        href="./manageUsers.php">Utilisateurs</a>
    <a class="sideMenuButton<?php checkURI("/UIWCoachManager.php") ?>"
        href="UIWCoachManager.php">Évaluateurs</a>
    <a class="sideMenuButton" href="localhost:3000/drill">Exercice</a>
    <a class="sideMenuButton" href="localhost:3000/course">Parcours</a>
    <a class="sideMenuButton<?php checkURI("/manageCap.php") ?>"
        href="./manageCap.php">Casquettes</a>
    <a class="sideMenuButton" href="http://localhost:3000/parkgroup">Carte des parcs</a>
</div>