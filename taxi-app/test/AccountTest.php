<?php

namespace test;

use App\Models\Account;
use App\Repositories\AccountRepository;
use PHPUnit\Framework\TestCase;
use controllers\AccountController;
class AccountTest extends TestCase {

	public function createPassangerAccount() {
		//given
		$inputSignup = [
			"name" => "Lucas Almeida da Silva",
			"email" => "lucas.silva89@email.com",
			"cpf" => "473.285.610-39",
			"is_passenger" => true,
			"password" => "123456"
		];

		//when
		$accountMock = $this->createPassengerAccountMock(AccountRepository::class);
		$accountRepositoryMock->method('createAccount')->willReturn($inputSignup);
		$accountController = new AccountController($accountRepositoryMock);

		$requestFactory = new RequestFactory();
		$request = $requestFactory->createRequest('POST', '/signup')
			->withBody(Stream::createFromString(json_encode($inputSignup)));

		$responseFactory = new ResponseFactory();
		$response = $responseFactory->createResponse();

		$response = $accountController->signup($request, $response);

		$this->assertEquals(200, $response->getStatusCode());

		$responseBody = json_decode((string) $response->getBody(), true);
		$this->assertEquals($inputSignup['name'], $responseBody['name']);
		$this->assertEquals($inputSignup['email'], $responseBody['email']);
		$this->assertEquals($inputSignup['cpf'], $responseBody['cpf']);
		$this->assertTrue($responseBody['is_passenger']);

		//then
	}

}