<?php
include_once "DBConnector.php";
$obj = new DBConnector();
global $id;
if (isset($_REQUEST["action"])){

    $action = $_REQUEST["action"];

    switch ($action){
        case "Prideti":

            $new_nr = $_REQUEST["nr"];
            $new_mark = $_REQUEST["mark"];
            $new_model = $_REQUEST["model"];
            $new_years = $_REQUEST["years"];
            $limitas = $_REQUEST["legal"];
            $fiksuotas = $_REQUEST["data"];
            if (($fiksuotas - $limitas) * 2.30 > 0){
                if (isset($_REQUEST["sumoketa"])){
                    $sumoketa = "Taip";
                    $bauda = ($fiksuotas - $limitas) * 2.30;
                }else{
                    $sumoketa = "Ne";
                    $bauda = ($fiksuotas - $limitas) * 2.30;
                }

            }else{
                $bauda = 0;
                $sumoketa = "Ne";
            }
            $obj->addCar($new_nr, $new_mark, $new_model,$new_years, $limitas,$fiksuotas, $bauda, $sumoketa);
            break;
        case "Istrinti":
            $obj->deleteCar($_REQUEST["id"]);
            break;
        case "Redaguoti":
            $obj->updateCar();
            break;
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        table, thead, th, tr, td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
            background-color: aqua;
        }

        .naujinti{
            margin-top: 20px;
        }

    </style>
</head>
<body>
<table>
    <?php

    $result = $obj->getAllCars();

    if ($result->num_rows > 0) {
        // output data of each row
        echo "<thead>";
        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>Numeris</th>";
        echo "<th>Marke</th>";
        echo "<th>Modelis</th>";
        echo "<th>Metai</th>";
        echo "<th>Leistinas greitis</th>";
        echo "<th>Fiksuotas greitis</th>";
        echo "<th>Bauda</th>";
        echo "<th>Sumoketa</th>";
        echo "</tr>";
        echo "</thead>";
        while ($keliu_ereliai = $result->fetch_assoc()) {
            echo "<form action='index.php' method='get'>";
            echo "<tr>";
            $id = $keliu_ereliai["id"];
            $nr = $keliu_ereliai["Numeris"];
            $mark = $keliu_ereliai["Marke"];
            $model = $keliu_ereliai["Modelis"];
            $years = $keliu_ereliai["Metai"];
            $legal_speed = $keliu_ereliai["Leistinas_greitis"];
            $fixed_speed= $keliu_ereliai["Fiksuotas_greitis"];
            $bauda= $keliu_ereliai["Bauda"];
            $sumoketa = $keliu_ereliai["Sumoketa"];
            echo "<td>$id</td>";
            echo "<td>$nr</td>";
            echo "<td>$mark</td>";
            echo "<td>$model</td>";
            echo "<td>$years</td>";
            echo "<td>$legal_speed</td>";
            echo "<td>$fixed_speed</td>";
            echo "<td>$bauda</td>";
            echo "<td>$sumoketa</td>";
            echo "<td><input type='hidden' name='id' value='$id'></td>";
            echo "<td><input type='submit' name='action' value='Istrinti'></td>";
            echo "<td><input type='submit' name='action' value='Redaguoti'></td>";
            echo "</tr>";
            echo "</form>";
        }
        echo "";
    } else {
        echo "0 results";
    }


    ?>
</table>
<form class="naujinti" action='#' method='get'>
    <tr>
        <td><input type='text' name='nr' placeholder='Numeris'></td>
        <td><input type='text' name='mark' placeholder='Marke'></td>
        <td><input type='text' name='model' placeholder='Modelis'></td>
        <td><input type='text' name='years' placeholder='Metai'></td>
        <td><input type='text' name='legal' placeholder='Leistinas greitis'></td>
        <td><input type='text' name='data' placeholder='Fiksuotas greitis'></td>
        <td><input type='checkbox' name='sumoketa'>Sumoketa?</td>
        <td><input type='submit' name='action' value='Prideti'></td>

    </tr>

</form>


</body>
</html>
