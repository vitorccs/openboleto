<?php

namespace Tests\OpenBoleto\Banco;
use OpenBoleto\Banco\Unicred;

// Alias the PHPUnit 6.0 ancestor if available, else fall back to legacy ancestor
if (class_exists('\PHPUnit\Framework\TestCase', true)) {
  class KernelTestCaseAncestor extends \PHPUnit\Framework\TestCase {}
} else {
  class KernelTestCaseAncestor extends \PHPUnit_Framework_TestCase {}
}

class UnicredTest extends KernelTestCaseAncestor
{
    public function testInstantiateWithoutArgumentsShouldWork()
    {
        $this->assertInstanceOf('OpenBoleto\\Banco\\Unicred', new Unicred());
    }

    public function testInstantiateShouldWork()
    {
        $instance = new Unicred(array(
            // Parâmetros obrigatórios
            'dataVencimento' => new \DateTime('2013-01-01'),
            'valor' => 10.50,
            'agencia' => 3302, // Até 4 dígitos
            'carteira' => 51, // 11, 21, 31, 41 ou 51
            'conta' => 2259, // Até 10 dígitos
            'sequencial' => 13951, // Até 10 dígitos
        ));

        $this->assertInstanceOf('OpenBoleto\\Banco\\Unicred', $instance);
        $this->assertEquals('13693.30202 00000.225904 00001.395136 9 55650000001050', $instance->getLinhaDigitavel());
        $this->assertSame('0000013951-3', (string) $instance->getNossoNumero());
    }
}
