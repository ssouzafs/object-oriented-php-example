<?php

namespace Source\Bank;

use Source\App\User;

class CheckingAccount extends Account
{
    private float $limit;

    /**
     * @param string $agency
     * @param string $account
     * @param User $client
     * @param float $limit
     * @param float $balance
     */
    public function __construct(string $agency, string $account, User $client, float $limit, float $balance = 0.0)
    {
        parent::__construct($agency, $account, $client, $balance);
        $this->limit = $limit;
    }

    /**
     * Função polimórfica.
     *
     * @param float $value
     * @return string
     */
    public function withdraw(float $value): string
    {
        $balanceAvailable = $this->balance + $this->limit;
        $flagMsg = "[ ERRO ]: Impossível sacar. *** Saldo Insuficiente ***";
        if ($balanceAvailable >= $value) {
            $this->balance -= abs($value);
            $flagMsg = "[ SAQUE ]: Sacou {$this->formatToBr($value)}. ";

            if ($this->balance < 0) {
                // Desconto com base na taxa de Juros
                $rate = abs($value) * $this->interestRate;
                $this->balance -= $rate;
                $flagMsg .= "Taxa de uso do limite: {$this->formatToBr($rate)}";
            }
        }
        return $flagMsg;
    }

    /**
     * Função polimórfica.
     *
     * @param float $value
     * @return string
     */
    public function deposit(float $value): string
    {
        $this->balance += $value;
        return "[ DEPÓSITO]: Depositou {$this->formatToBr($value)}!";
    }

    /**
     * @return float
     */
    public function getLimit(): float
    {
        return $this->limit;
    }

    /**
     * @param float $limit
     */
    public function setLimit(float $limit): void
    {
        $this->limit = $limit;
    }

}