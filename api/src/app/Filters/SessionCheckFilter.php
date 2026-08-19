<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\API\ResponseTrait;
use Exception;

class SessionCheckFilter implements FilterInterface {
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param RequestInterface $request
	 * @param array|null                         $params
	 *
	 * @return mixed
	 */
	use ResponseTrait;
	protected $request;

	public function before(RequestInterface $request, $arguments = null) {
		helper(["text"]);

		try {
			service('Configs')->write_officedata();
			$authentication = service('Authentication');
			if ($authentication->session()) {
				$user_id = $authentication->session("userId");
				$profile = service('Users')->profile($user_id);
				$authentication->set_userdata($profile);

				$prevUserId = $authentication->session("prevUserId") ?: "";
				if ($prevUserId) {
					$prevProfile = service('Users')->profile($prevUserId);
					$authentication->set_prevUserdata($prevProfile);
				}
			}
		} catch (Exception $e) {
		}
	}

	//--------------------------------------------------------------------

	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null                          $arguments
	 *
	 * @return void
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {
	}

	//--------------------------------------------------------------------
}
