<?php

require __DIR__ . "/source/autoload.php";

$client = new \Source\App\User(
    "Maria S",
    "Silva",
);

$saving = new \Source\Bank\SavingsAccount(
    '09656-02',
    '5689',
    $client,
    100
);

$checking = new \Source\Bank\CheckingAccount(
    '09656-02',
    '5689',
    $client,
    100,
    100,
);

echo "##### CONTA POUPANÇA ##### <br><br>";
echo $saving->informExtract() . "<hr>";

echo $saving->deposit(100) . "<br>";

echo $saving->informExtract() . "<hr>";

echo $saving->withdraw(100). "<br>";

echo $saving->informExtract() . "<hr>";

echo $saving->withdraw(30). "<br>";

echo $saving->informExtract() . "<hr>";

echo $saving->withdraw(80). "<br>";

echo $saving->informExtract() . "<hr>";

echo $saving->withdraw(30). "<br>";

echo $saving->informExtract() . "<hr>";

echo "<br>##### CONTA CORRENTE ##### <br><br>";

echo $checking->informExtract() . "<hr>";

echo $checking->deposit(100) . "<br>";

echo $checking->informExtract() . "<hr>";

echo $checking->withdraw(100). "<br>";

echo $checking->informExtract() . "<hr>";

echo $checking->withdraw(100). "<br>";

echo $checking->informExtract() . "<hr>";

echo $checking->withdraw(100). "<br>";

echo $checking->informExtract() . "<hr>";

echo $checking->withdraw(.60). "<br>";

echo $checking->informExtract() . "<hr>";
