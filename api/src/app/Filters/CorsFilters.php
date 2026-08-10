<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CorsFilters implements FilterInterface {
    
	public function before(RequestInterface $request, $arguments = null) {
		header('Access-Control-Allow-Origin: http://localhost:3000');
		header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
		header('Access-Control-Allow-Headers: Content-Type, Authorization');
		header('Access-Control-Allow-Credentials: true');

		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
			header('Content-Length: 0');
			header('Content-Type: text/plain');
			exit;
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
		return $response;
	}
}
