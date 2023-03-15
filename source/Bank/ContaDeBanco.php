<?php

namespace Source\Bank;

abstract class ContaDeBanco
{
    public string $nomeDaAgencia;
    public string $conta;
    public string $client;
    public float $saldo;
    public ?float $taxaDeJuros;
    public string $tipo;
    public ?float $limite;

    /**
     * @param string $nomeAg
     * @param string $c
     * @param string $usuario
     * @param float $s
     * @param float|null $taxa
     * @param string $t
     */
    public function __construct(string $nomeAg, string $c, string $usuario, float $s, ?float $taxa, string $t)
    {
        $this->nomeDaAgencia = $nomeAg;
        $this->conta = $c;
        $this->client = $usuario;
        $this->saldo = $s;
        $this->taxaDeJuros = $taxa;
        $this->tipo = $t;
    }

    /**
     * Mostra saldo de acordo com o locale informado. Caso o locale seja informado errado ou não exista o retorno será o padrão pt-br.
     *
     * @param string $l
     * @param string $valor
     * @return string
     */
    public function formatarParaHumanos(string $l, string $valor): string
    {
        if ($l === 'pt_br') {
            return "Saldo: " . number_format($valor, 2, ",", ".");
        } else if ($l === "en_US") {
            return "Saldo: $" . number_format($valor, 2);
        } else if ($l === "en_IN") {
            return "Saldo: INR" . number_format($valor, 2);
        } else if ($l === "jp-JP") {
            return "Saldo: JP¥" . number_format($valor, 2);
        } else if ($l === "EUR") {
            return "Saldo: " . number_format($valor, 2, ",", ".") . "€";
        }
        return "Saldo: " . number_format($valor, 2, ",", ".");
    }

    /**
     * @return string
     */
    protected function getClient(): string
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    protected function setClient(string $client): void
    {
        $this->client = $client;
    }

    /**
     * @param float $v
     * @return string
     */
    public function sacar(float $v): string
    {
        $flagMsg = "[ ERRO ]: Impossível sacar. *** Saldo Insuficiente ***";
        if ($this->tipo === "poupança") {
            if (($this->saldo - $v) >= 0) {
                $this->saldo -= abs($v);
                return "[ SAQUE ]: Sacou {$this->formatarParaHumanos('pt_br', $v)}.";
            } else {
                return "[ ERRO NO SAQUE ]: *** SALDO INSUFICIENTE ***";
            }
        } else if ($this->tipo === "corrente") {
            $saldoTotal = $this->saldo + $this->limite;
            if ($saldoTotal >= $v) {
                $this->saldo -= abs($v);
                $flagMsg = "[ SAQUE ]: Sacou {$this->formatarParaHumanos('pt_br',$v)}. ";

                if ($this->saldo < 0) {
                    // cobrança de taxa com base na taxa de Juros
                    $taxa = abs($v) * $this->taxaDeJuros;
                    $this->saldo -= $taxa;
                    $flagMsg .= "Taxa de uso do limite: {$this->formatarParaHumanos('pt_br',$taxa)}";
                }
            }
        }
        return $flagMsg;
    }

    /**
     * @param float $v
     * @return string
     */
    public function setSaldo(float $v): string
    {
        if ($this->tipo === "poupança") {
            // Rendimento para o cliente com base na taxa de juros que o banco paga.
            $remuneracao = $v * $this->taxaDeJuros;
            $this->saldo += ($v + $remuneracao);
            return "[ DEPÓSITO]: Depositou {$this->formatarParaHumanos('pt_br',$v)}. Rendeu {$this->formatarParaHumanos('pt_br',$remuneracao)}!";
        }
        $this->saldo += $v;
        return "[ DEPÓSITO]: Depositou {$this->formatarParaHumanos('pt_br',$v)}!";
    }
}