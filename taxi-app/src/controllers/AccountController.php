<?php

namespace App\Controllers;

use App\Repositories\AccountRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController {
	private AccountRepository $accountRepository;

	public function __construct(AccountRepository $accountRepository) {
		$this->accountRepository = $accountRepository;
	}

	public function signup(Request $request, Response $response) {
		$data = json_decode($request->getBody()->getContents(), true);

		if (!isset($data['name'], $data['email'], $data['cpf'], $data['password'])) {
			return $response->withStatus(400)->withJson(['error' => 'Dados inválidos']);
		}

		if ($this->accountRepository->getByEmail($data['email'])) {
			return $response->withStatus(400)->withJson(['error' => 'Email já cadastrado']);
		}

		$account = $this->accountRepository->createAccount(
			$data['name'], $data['email'], $data['cpf'], $data['password'],
			$data['is_passenger'] ?? false, $data['is_driver'] ?? false, $data['car_plate'] ?? null
		);

		return $response->withJson($account);
	}
}
