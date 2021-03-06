<?php

class APIv1 extends CustomModule
{
	protected $request_methods = 'GET';

	public function __construct()
	{
		parent::__construct();

		$response_code = 200;
		$error         = 'An unexcepted error has occurred.';

		if (!is_array($this->request_methods))
		{
			$this->request_methods = array($this->request_methods);
		}

		// Checks the request method
		if (!in_array($_SERVER['REQUEST_METHOD'], $this->request_methods))
		{
			$response_code = 400;
			$error         = 'Invalid request method.';
		}

		// Checks the key
		try
		{
			if ($_SERVER['REQUEST_METHOD'] == 'PUT')
			{
				parse_str(file_get_contents("php://input"), $_PUT);

				foreach ($_PUT as $key => $value)
				{
					unset($_PUT[$key]);

					$_PUT[str_replace('amp;', '', $key)] = $value;
				}

				$_REQUEST = array_merge($_REQUEST, $_PUT);
			}

			if (isset($_REQUEST['key']))
			{
				if (strlen($_REQUEST['key']) == 40)
				{
					$uid = $this->redis->get('user:api:' . $_REQUEST['key']);

					if ($uid)
					{
						$this->uid = $uid;
					}
					else
					{
						throw new Exception('Invalid key.');
					}
				}
				else
				{
					throw new Exception('Invalid key length.');
				}
			}
			else
			{
				throw new Exception('Missing key.');
			}
		}
		catch (Exception $e)
		{
			$response_code = 401;
			$error         = $e->getMessage();
		}

		if (isset($_REQUEST['suppress_response_codes']))
		{
			$response_code = 200;
		}

		$this->response_code = $response_code;

		if ($response_code != 200)
		{
			$this->error = $error;
		}

		Browser::status($response_code);
	}

	public function __destruct()
	{
		// Unsure why I had to put this here, I guess it's being overridden somewhere in PICKLES
		header('Content-type: application/json');

		if (isset($this->return['response_code']))
		{
			Browser::status($this->return['response_code']);
		}
	}
}

?>
