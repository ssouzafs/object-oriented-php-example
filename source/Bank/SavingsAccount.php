<?php

namespace Source\Bank;

use Source\App\User;

class SavingsAccount extends Account
{

    /**
     * @param string $agency
     * @param string $account
     * @param User $client
     * @param float $balance
     */
    public function __construct(string $agency, string $account, User $client, float $balance = 0.0)
    {
        parent::__construct($agency, $account, $client, $balance);
    }

    /**
     * Função polimorfada.
     *
     * @param float $value
     * @return string
     */
    public function withdraw(float $value): string
    {
        if (($this->balance - $value) >= 0) {
            $this->balance -= abs($value);
            return "[ SAQUE ]: Sacou {$this->formatToBr($value)}.";
        }
        return "[ ERRO NO SAQUE ]: *** SALDO INSUFICIENTE ***";
    }

    /**
     * Função polimorfada.
     *
     * @param float $value
     * @return string
     */
    public function deposit(float $value): string
    {
        // Rendimento com base na taxa de juros.
        $remuneration = $value * $this->interestRate;
        $this->balance += ($value + $remuneration);
        return "[ DEPÓSITO]: Depositou {$this->formatToBr($value)}. Rendeu {$this->formatToBr($remuneration)}!";
    }

}