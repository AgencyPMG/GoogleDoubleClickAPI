<?PHP

/*
Google Doubleclick for Advertisers API
Created by PMG <mailto:seo@pmg.co>, Chris Alvares<mailto:chris.alvares@pmg.co>
*/

/*
Please note: This is not your Google Account Username and Password, it is the Username and password for DoubleClick
*/

define("DFA_DEFAULT_USERNAME", "ENTER_USERNAME_HERE");
define("DFA_DEFAULT_PASSWORD", "ENTER_PASSWORD_HERE");

/*
Note: If you have a token that you already recieved somehow, then place it here, otherwise, keep this blank
Having a token here may speed things up a little bit, but the token expiration time is unknown, so it might expire.
Using the token is good for testing purposes.
*/

define("DFA_DEFAULT_APITOKEN", "ENTER_EXISTING_TOKEN_HERE");
//define("DFA_DEFAULT_APITOKEN", "");
define("DFA_VERSION", "1.16");
define("DFA_NAMESPACE", "http://www.doubleclick.net/dfa-api/");

define("DFA_DEFAULT_APPLICATION_NAME", "DFA_PHP_API");


?>