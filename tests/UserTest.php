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
    public function it_should_be_able_to_create_user(){
        $this->mockUserModel->method('registerUser')->willReturn(True);
        $userResult = $this->userController->createUser('Ana Luisa Santos', 'beatriz@example.com', '123456');
        $this->assertTrue($userResult);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_sign_in(){

        $this->mockUserModel->method('getUserByEmail')->willReturn([
            "id"=>1,
            "user_fullname" => "Ana Luisa Santos",
            "email"=> "ana@example.com",
            
            "password"=> password_hash(123456, PASSWORD_DEFAULT),
        ]);

        $userResult = $this->userController->login("ana@example.com", "123456");
        $this->assertTrue($userResult);
        $this->assertEquals(1, $_SESSION["id"],);
        $this->assertEquals('Ana Luisa Santos', $_SESSION["user_fullname"],);
        $this->assertEquals('ana@example.com', $_SESSION["email"]);
    }


    #[\PHPUnit\Framework\Attributes\Test]
    public function it_shouldnt_login_with_invalid_credentials(){

            $this->mockUserModel->method('getuserByEmail')->willReturn([
            "id"=>1,
            "user _fullname" => "Ana Luisa Santos",
            "email"=> "ana@example.com",
            "password"=> password_hash(123456, PASSWORD_DEFAULT),
        ]);
        
        $userResult = $this->userController->login("ana@example.com", "12345");
        $this->assertFalse($userResult);
    }


    #[PHPUnit\Framework\Attributes\Test]
    public function it_should_be_able_to_check_user_by_email(){
         $this->mockUserModel->method('getuserByEmail')->willReturn([
            "id"=>1,
            "user _fullname" => "Ana Luisa Santos",
            "email"=> "ana@example.com",
            "password"=> '$2y$10$wwh8v4aP/UFlocuM0NIk9.tIg6mH.pe4.CkcMLKLlhMVibpF3Uf6q',
        ]);

        $userResult = $this->userController->checkUserByEmail('ana@example.com');
        $this->assertNotNull($userResult);
        $this->assertEquals('ana@example.com', $userResult['email']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_should_verify_if_is_logged_in(){
    $_SESSION["id"]= 1;
    $userResult = $this->userController->isLoggedIn();
    $this->assertTrue($userResult);
    }
}
?>