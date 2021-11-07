<?php

namespace Source\Bank;

use Source\App\User;

abstract class Account
{
    protected string $agency;
    protected string $account;
    protected User $client;
    protected float $balance;
    protected float $interestRate;

    /**
     * @param string $agency
     * @param string $account
     * @param User $client
     * @param float $balance
     */
    protected function __construct(string $agency, string $account, User $client, float $balance = 0.0)
    {
        $this->agency = $agency;
        $this->account = $account;
        $this->balance = $balance;
        $this->client = $client;
        $this->interestRate = 0.006;
    }

    /**
     * @return string
     */
    public function informExtract(): string
    {
        return "[ EXTRATO ] Saldo Atual: " . $this->formatToBr($this->balance);
    }

    /**
     * Função que formata valor monetário para padrão brasileiro..
     *
     * @param float $value
     * @return string
     */
    protected function formatToBr(float $value): string
    {
        return "R$ " . number_format($value, 2, ",", ".");
    }

    /**
     * @return User
     */
    protected function getClient(): User
    {
        return $this->client;
    }

    /**
     * @param User $client
     */
    protected function setClient(User $client): void
    {
        $this->client = $client;
    }

    /**
     * @param float $value
     * @return string
     */
    abstract public function withdraw(float $value): string;

    /**
     * @param float $value
     * @return string
     */
    abstract public function deposit(float $value): string;

}