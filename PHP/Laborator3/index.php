<?php

declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2000-01-01",
        "amount" => 560.00,
        "description" => "Shopping",
        "merchant" => "Shopping Malldova",
    ],
    [
        "id" => 2,
        "date" => "2001-02-02",
        "amount" => 300.00,
        "description" => "Dinner",
        "merchant" => "Fast food",
    ],
    [
        "id" => 3,
        "date" => "2002-03-03",
        "amount" => 630.00,
        "description" => "Shopping for Volkodav",
        "merchant" => "Nr1",
    ]
];



function calculateTotalAmount(array $transactions): float {
    return array_sum(array_column($transactions, 'amount'));
}


function findTransactionByDescription(array $transactions, string $descriptionPart) {
    $descriptions = array_column($transactions, 'description');
    foreach ($descriptions as $index => $description) {
        if (strpos($description, $descriptionPart) !== false) {
            return $transactions[$index];
        }
    }
    return null;
}


function findTransactionById(array $transactions, int $id) {
    $ids = array_filter($transactions, function ($transaction) use ($id) {
        return $transaction['id'] === $id;
    });

    return $ids ?: null;
}


function daysSinceTransaction(string $date, array $transactions): int {
    $transactionDate = new DateTime($date);
    $currentDate = new DateTime();
    $interval = $currentDate->diff($transactionDate);
    return $interval->days; 
}


function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}
addTransaction(4, "2025-03-09", 150.00, "Book purchase", "Librarius");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laborator3</title>
</head>

<body>
    <table border="1px" align="center" cellspacing="0" cellpadding="3" width="40%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
            <th>Days passed</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($transactions as $transaction): ?>
        <tr>
                <td><?php echo $transaction['id'] ?></td>
                <td><?php echo $transaction['date'] ?></td>
                <td><?php echo $transaction['amount'] ?></td>
                <td><?php echo $transaction['description'] ?></td>
                <td><?php echo $transaction['merchant'] ?></td>
                <td><?php echo daysSinceTransaction($transaction['date'], $transactions); ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<p><?php print_r(calculateTotalAmount($transactions))?></p>
<p><?php print_r(findTransactionByDescription($transactions, 'Volkodav'))?></p>
<p><?php print_r(findTransactionById($transactions, 3))?></p>
<p><?php 
    usort($transactions, function($a, $b) {
        $dateA = new DateTime($a['date']);
        $dateB = new DateTime($b['date']);
        return $dateA <=> $dateB;
    });
    print_r($transactions);
?></p>
<p><?php 
    usort($transactions, function($a, $b) {
        return $b['amount'] - $a['amount'];
    });
    print_r($transactions);
?></p>
</body>

</html>