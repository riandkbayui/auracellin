<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SanitizePostFilter implements FilterInterface {
	public function before(RequestInterface $request, $arguments = null)
	{
		if ($request->getMethod() === 'post') {
			$post = $request->getPost();

			// Fields yang berupa angka
			$numbers = [
				'id', 'user_id', 'amount', 'amount_request', 'amount_admin', 'amount_received', 
				'bank_id', 'is_checked','package_id', 'duration_days', 'price', 
				'reward_point', 'bonus_referral_amount', 'bonus_referral_max',
			];

			// Fields yang berupa alfanumerik
			$alphanumeric = [
				'code', 'name', 'phone', 'address', 'profesion', 'status', 'royalty',
				'description', 'invoice', 'token', 'group', 'key', 'value', 'comission',
				'account_name', 'account_address', 'is_public', 'is_show', 'is_success',
			];

			$emails = ['email'];
			$usernames = ['username', 'referral'];

			$urls = [''];

			$floats = []; // Tambahkan jika ada field float yang spesifik
			$booleans = []; // Contoh field boolean

			// Field yang boleh mengandung HTML aman (dengan tag tertentu)
			$allow_html = ['description', 'benefits'];

			// Tag HTML yang diperbolehkan
			$allowed_tags = '<b><i><u><strong><em><br><ul><ol><li><p>';

			$sanitized = [];

			foreach ($post as $key => $value) {
				if (in_array($key, $numbers)) {
					$sanitized[$key] = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
				} elseif (in_array($key, $floats)) {
					$sanitized[$key] = (float) $value;
				} elseif (in_array($key, $booleans)) {
					$sanitized[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
				} elseif (in_array($key, $alphanumeric)) {
					$sanitized[$key] = preg_replace('/[<>"%;&+\\\]/', '', (string) $value);
				} elseif (in_array($key, $allow_html)) {
					// Izinkan HTML aman
					$sanitized[$key] = strip_tags(trim($value), $allowed_tags);
				} elseif (in_array($key, $emails)) {
					$sanitized[$key] = preg_replace('/[^0-9a-z\.\@\-]/', '', strtolower($value));
				} elseif (in_array($key, $urls)) {
					$sanitized[$key] = preg_replace('/[^0-9a-zA-Z\.\:\/\?\=\_]/', '', $value);
				} elseif (in_array($key, $usernames)) {
					$sanitized[$key] = preg_replace('/[^0-9a-z]/', '', strtolower($value));
				} elseif (is_string($value)) {
					// Default: hilangkan semua tag HTML
					$sanitized[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
				} else {
					$sanitized[$key] = $value;
				}
			}

			$request->setGlobal('post', $sanitized);
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
	}
}
