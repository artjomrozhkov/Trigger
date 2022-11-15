<?php
require_once ('connect.php');
global $yhendus;
//andmete lisamine tabelisse
if(isset($_REQUEST['LisamisVorm']) && !empty($_REQUEST['nimi'])){
    $paring=$yhendus->prepare('INSERT INTO loomadevarjupaik(nimi,vanus,lemmikToit) Values(?,?,?)');
    $paring->bind_param('sis',$_REQUEST['nimi'],$_REQUEST['vanus'],$_REQUEST['lemmiktoit']);
    $paring->execute();
}


//kustutamine
if(isset($_REQUEST['kustuta'])) {
    $paring = $yhendus->prepare('DELETE FROM loomadevarjupaik WHERE loomaID=?');
    $paring->bind_param('i', $_REQUEST['kustuta']);
    $paring->execute();
}

$paring=$yhendus->prepare('SELECT loomaID, nimi,vanus,lemmikToit,linnID	 FROM loomadevarjupaik');
$paring->bind_result($loomaID, $nimi, $vanus,$lemmikToit,$linnID);
$paring->execute();
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomadevarjupaik</title>
</head>
<body>

<h1>Loomade tabel</h1>
<table>
    <tr>
        <th>loomaID</th>
        <th>Nimi</th>
        <th>Vanus</th>
        <th>Lemmiktoit</th>
        <th>Linn</th>
    </tr>
    <?php
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>". htmlspecialchars($loomaID)."</td>";
        echo "<td>". htmlspecialchars($nimi)."</td>";
        echo "<td>". htmlspecialchars($vanus)."</td>";
        echo "<td>". htmlspecialchars($lemmikToit)."</td>";
        echo "<td>". htmlspecialchars($linnID)."</td>";
        echo "<td><a href='?kustuta=$loomaID'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>
<h2>Uue looma lisamine</h2>
<form name="uusloom" method="post" action="?">
    <input type="hidden" name="LisamisVorm">
    <input type="text" name="nimi" placeholder="Looma nimi">
    <br>
    <br>
    <input type="text" name="vanus" placeholder="Looma vanus">
    <br>
    <br>
    <input type="text" name="lemmiktoit" placeholder="Looma lemmiktoit">
    <br>
    <br>
    <input type="submit" value="OK">
</form>
</body>
<?php
$yhendus->close();
?>
</html>
