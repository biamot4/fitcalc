<?php

use PHPUnit\Framework\TestCase;

use Controller\UserController; 

use Model\User;

class Usertest extends TestCase {
    private $userController;
    private $mockUserModel;
    public function setUp(): void {
        $this->mockUserModel = $this->createMock(User::class);

        $this->userController = new UserController($this->mockUserModel);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_crteate_user(){
        $userResult = $this->userController->createUser('Ana Luisa Santos', 'beatriz@example.com', '123456');
        $this->assertTrue($userResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_sign_in(){
        $this->mockUserModel->method('getuserByEmail')->willReturn([
            "id"=>1,
            "user _fullname" => "Ana Luisa Santos",
            "email"=> "ana@example.com",
            "password"=> password_hash(123456, PASSWORD_DEFAULT),
        ]);
    }
}





?>