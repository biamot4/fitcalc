<?php

use Controller\ImcController;
use PHPUnit \ Framework \ TestCase;

class ImcTest extends TestCase{

    //Irá fazer referência a classe ImcController 
    //Responsável por realizar a comunicação com o banco de dados e a lógica da aplicação
    private $imcController;

    protected function setUp(): void{
        $this->imcController = new ImcController();
    }

//Verificar cálculo do IMC

#[\PHPUnit\Framework\Attributes\Test]
public function it_should_be_able_to_calculate_bmi (){
    $weight = 68;
    $height = 1.68;
   $imcResult = $this->imcController->calculateImc($weight, $height);
    
    $this->assertArrayHasKey('imc', $imcResult);
    $this->assertArrayHasKey('BMIrange', $imcResult);

    $this->assertEquals(24.09, $imcResult['imc']);
    $this->assertEquals('Peso Normal', $imcResult['BMIrange']);

}


//Verificar a validação de campos inválidos
#[PHPUnit\Framework\Attributes\Test]
public function it_shouldnt_be_able_to_calculate_bmi_with_invalid_inputs (){
$imcResult = $this->imcController->calculateImc(-68, 1.68);
$this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);

$imcResult = $this->imcController->calculateImc(68, -1.68);
$this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);

$imcResult = $this->imcController->calculateImc(-68, -1.68);
$this->assertEquals('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);


}

//Verificar a validação de campos nulos ou vazios
#[PHPUnit\ Framework\Attributes\Test]
public function it_shouldnt_be_able_to_calculate_bmi_with_null_empty_inputs (){
    $imcResult = $this->imcController->calculateImc(null, 0);
    $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC', $imcResult['BMIrange']);

    $imcResult = $this->imcController->calculateImc(0, null);
    $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC', $imcResult['BMIrange']);

    $imcResult = $this->imcController->calculateImc(null, null);
    $this->assertEquals('Por favor, informe peso e altura para obter o seu IMC', $imcResult['BMIrange']);

}
//Obter o IMC e Classificar
#[PHPUnit\ Framework\Attributes\Test]
public function it_should_be_able_to_get_an_bmi_range(){
    $weight = 68;
    $height = 1.68;
    $imcResult = $this->imcController->calculateImc($weight, $height);
    $this->assertStringNotContainsString('O peso e a altura devem conter valores positivos.', $imcResult['BMIrange']);
    $this->assertStringNotContainsString('Por favor, informe peso e altura para obter o seu IMC', $imcResult['BMIrange']);

    $this->assertStringNotContainsString('Peso normal', $imcResult['BMIrange']);
}

// Salvar o IMC
#[PHPUnit\ Framework\Attributes\Test]
public function it_should_be_able_to_save_bmi(){

}
}

?>


