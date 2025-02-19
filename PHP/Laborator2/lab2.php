<?php
    $day = date("l");

    function johnstyles ($day){
        if($day == "Monday" || $day == "Wednesday" || $day == "Friday"){
            echo "8:00-12:00";
        } else {
            echo "Нерабочий день";
        }
    }

    function janedoe ($day){
        if($day == "Tuesday" || $day == "Thursday" || $day == "Saturday"){
            echo "12:00-16:00";
        } else {
            echo "Нерабочий день";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laborator2</title>
</head>
<body>
    <table border="1px" align="center" cellspacing="0" cellpadding="3" width="30%">
        <th>№</th>
        <th>Фамилия Имя</th>
        <th>График работы</th>
        <tr>
            <td>1</td>
            <td>John Styles</td>
            <td><?php johnstyles($day)?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Doe</td>
            <td><?php janedoe($day)?></td>
        </tr>
</table>
</body>
</html>