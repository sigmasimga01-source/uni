<?php


// $x = ["banana", "apple", "coconut", "tomato", "cucumber"];

// $apple = array_filter($x, fn($val) => $val == "apple");

// print_r($apple);



$users = [
    [
        "name" => "gela",
        "lname" => "barkalaia",
        "dep" => "sales",
        "pay" => 3000,
        "bonus" => 500
    ],
    [
        "name" => "gela2",
        "lname" => "barkalaia2",
        "dep" => "sales2",
        "pay" => 30010,
        "bonus" => 5020
    ],

];



$new_user = [
    "name" => $_POST['name'],
    "lname" => $_POST['lname'],
    "dep" => $_POST['dep'],
    "pay" => $_POST['pay'],
    "bonus" => $_POST['bonus']
];

$users[] = $new_user;


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>

    <table>
        <thead>
            <th>name</th>
            <th>Lname</th>
            <th>dep</th>
            <th>pay</th>
            <th>bonus</th>
            <td>SUM</td>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['name'] ?></td>
                    <td><?= $user['lname'] ?></td>
                    <td><?= $user['dep'] ?></td>
                    <td><?= $user['pay'] ?></td>
                    <td><?= $user['bonus'] ?></td>
                    <?php
                    $sum = $user['bonus'] + $user['pay'];
                    $color = "green";

                    if ($sum < 300) {
                        $color = "red";
                    } else if ($sum > 300 && $sum <= 700) {
                        $color = "yellow";
                    }
                    echo "<td style=\"background-color:" . $color . ";\">" . $sum . "</td>";
                    ?>
                </tr>
            <?php endforeach; ?>
        </tbody>


    </table>


    <form action="" method="post">
        <div style="display: flex; flex-direction: column; width: 200px;">
            <label for="name">name:</label>
            <input type="text" name="name" id="">

            <label for="lname">lname:</label>
            <input type="text" name="lname" id="">

            <label for="dep">dep:</label>
            <input type="text" name="dep" id="">

            <label for="pay">pay:</label>
            <input type="number" name="pay" id="">

            <label for="bonus">bonus:</label>
            <input type="number" name="bonus" id="">

            <input type="submit" value="Submit">
        </div>
    </form>

</body>

</html>