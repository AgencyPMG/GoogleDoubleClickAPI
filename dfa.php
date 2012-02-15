<?PHP

/*
Copyright PMG 2012

*/

set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());
require_once('dfa_config.php');


class DFA
{
	protected $username,$password,$auth_token;
	
	public function __construct($existing_auth_token=null)
	{
		$username = DFA_DEFAULT_USERNAME;
		$password = DFA_DEFAULT_PASSWORD;
		if($existing_auth_token == null) $existing_auth_token = DFA_DEFAULT_APITOKEN;
		
	}
	
	public function getAuthToken()
	{
		if($auth_token == "")
		{
			return getNewAuthToken();
		}
		return $auth_token;
	}
	
	protected function getNewAuthToken()
	{
		$loginWsdl = 'https://advertisersapi.doubleclick.net/v'.DFA_VERSION.'/api/dfa-api/login?wsdl';
		$namespace = DFA_NAMESPACE . 'v' .DFA_VERSION;

	}
	
	

}



?>