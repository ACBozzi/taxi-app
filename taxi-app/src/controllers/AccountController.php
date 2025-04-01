<?php

namespace AnnaBozzi\TaxiApp\Controllers;

use AnnaBozzi\TaxiApp\repositories\AccountRepository;
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
			$payload = json_encode(['error' => 'Dados inválidos']);
			$response->getBody()->write($payload);
			return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
		}

		if ($this->accountRepository->getByEmail($data['email'])) {
			$payload = json_encode(['error' => 'Email já cadastrado']);
			$response->getBody()->write($payload);
			return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
		}

		$account = $this->accountRepository->createAccount(
			$data['name'], $data['email'], $data['cpf'], $data['password'],
			$data['is_passenger'] ?? false, $data['is_driver'] ?? false, $data['car_plate'] ?? null
		);

		$response->getBody()->write(json_encode($account));
		return $response->withHeader('Content-Type', 'application/json');
	}

	public function getAccount(Request $request, Response $response, array $args){
		$accountId = $args['id'] ?? null;

		if (!$accountId) {
			$payload = json_encode(['error' => 'ID inválido']);
			$response->getBody()->write($payload);
			return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
		}

		$account = $this->accountRepository->getByEmail($accountId);

		if (!$account) {
			$payload = json_encode(['error' => 'Conta não encontrada']);
			$response->getBody()->write($payload);
			return $response->withStatus(404)->withHeader('Content-Type', 'application/json');
		}

		$response->getBody()->write(json_encode($account));
		return $response->withHeader('Content-Type', 'application/json');

	}

	public function isValidEmail() {}
	public function isValidName() {}
	public function isValidCPF() {}
	public function isValidCarPlate() {}
	public function isValidLength() {}
	public function allDigitsAreSame() {}
	public function clean() {}
}
