<?PHP

/*
Copyright PMG 2012

*/

set_include_path(dirname(__FILE__) . PATH_SEPARATOR . get_include_path());
include_once('dfa_config.php');
include_once('DfaHeadersUtil.php');
include_once('dfa_creative.php');

class DFA
{
	protected $username,$password,$auth_token;
	
	public $application_name = DFA_DEFAULT_APPLICATION_NAME;
	public $debug=false;
	protected $namespace, $wsdl_base;
	
	
	public function __construct($username=null, $password=null, $existing_auth_token=null)
	{
		if($username==null) $username = DFA_DEFAULT_USERNAME;
		if($password==null) $password = DFA_DEFAULT_PASSWORD;
		if($existing_auth_token == null) $existing_auth_token = DFA_DEFAULT_APITOKEN;

		$this->username = $username;
		$this->password = $password;
		$this->auth_token = $existing_auth_token;
		
		$this->namespace = DFA_NAMESPACE . 'v' .DFA_VERSION;
		$this->wsdl_base = 'https://advertisersapi.doubleclick.net/v'.DFA_VERSION.'/api/dfa-api/';
		
		
	}
	
	public function getAuthToken()
	{
		if($this->auth_token == "")
		{
			return $this->getNewAuthToken();
		}
		return $this->auth_token;
	}
	
	protected function getNewAuthToken()
	{
		$loginWsdl = $this->wsdl_base . 'login?wsdl';
		
		$options = array('encoding' => 'utf-8');

		$loginService = new SoapClient($loginWsdl, $options);
		try 
		{
		  // Authenticate.
		  $result = $loginService->authenticate($this->username, $this->password);
		  $this->auth_token = $result->token;
		  return $this->auth_token;
		}
		catch (Exception $e) 
		{
			
		}
		return false;
	}
	
	protected function getNewSOAPClient($wsdlaction)
	{
		$wsdl = $this->wsdl_base . $wsdlaction . '?wsdl';
		
		$soapClient = new SoapClient($wsdl, array('encoding' => 'utf-8'));

		$headers = array(DfaHeadersUtil::createWsseHeader(
						$this->username, $this->getAuthToken()),
		    			DfaHeadersUtil::createRequestHeader($this->namespace, $this->application_name));
		    			
		$soapClient->__setSoapHeaders($headers);
		return $soapClient;
		
	}
	
	

}



?>