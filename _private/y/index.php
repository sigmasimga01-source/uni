<?php

$data = [
    [
        'name' => 'John',
        'surname' => 'Doe',
        'birthday' => '1990-01-01',
        'speciality' => 'Developer'
    ],
    [
        'name' => 'John',
        'surname' => 'Doe',
        'birthday' => '1990-01-01',
        'speciality' => 'Developer'
    ],
    [
        'name' => 'John',
        'surname' => 'Doe',
        'birthday' => '1990-01-01',
        'speciality' => 'Developer'
    ],

    ['name' => 'Jane', 'surname' => 'Smith', 'birthday' => '1985-05-15', 'speciality' => 'Designer'],
    ['name' => 'Emily', 'surname' => 'Johnson', 'birthday' => '1992-09-23', 'speciality' => 'Manager'],
];

$filtered = array_filter($data, fn($st) => $st['speciality'] == 'Developer');


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .bg,
        th,
        td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
            padding: 0.1rem;
        }

        th {
            background-color: lightgray;
        }
    </style>
</head>

<body>
    <table class="bg">
        <thead>
            <h1>ALL</h1>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Birthday</th>
                <th>Speciality</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $person): ?>
                <tr>
                    <td><?= $person['name']; ?></td>
                    <td><?= $person['surname']; ?></td>
                    <td><?= $person['birthday']; ?></td>
                    <td><?= $person['speciality']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <table class="bg">
        <thead>
            <h1>DEVELOPERS</h1>
            <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Birthday</th>
                <th>Speciality</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filtered as $person): ?>
                <tr>
                    <td><?= $person['name']; ?></td>
                    <td><?= $person['surname']; ?></td>
                    <td><?= $person['birthday']; ?></td>
                    <td><?= $person['speciality']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>