<?php
/**
 * A utility class to handle creating the SOAP headers for DFA SoapClients.
 *
 * PHP version 5
 * PHP extensions: SoapClient.
 *
 * Copyright 2011, Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package    GoogleApiAdsDfa
 * @subpackage v1_16
 * @category   WebServices
 * @copyright  2011, Google Inc. All Rights Reserved.
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License,
 *             Version 2.0
 * @author     Joseph DiLallo <api.jdilallo@gmail.com>
 */

define ("WSSE_NAMESPACE", 'http://docs.oasis-open.org/wss/2004/01/' .
    'oasis-200401-wss-wssecurity-secext-1.0.xsd');

class DfaHeadersUtil {
  /**
   * The DfaHeadersUtil class is not meant to have any instances.
   * @access private
   */
  private function __construct() {}

  /**
   * Creates and returns the WSSE security header required for requests sent to
   * all services except the login service.
   * @param string $username DFA username
   * @param string $authToken DFA authentication token
   * @return SoapHeader a complete WSSE security header
   */
  public static function createWsseHeader($username, $authToken) {
    $usernameVar = new SoapVar($username, XSD_STRING, null,
        WSSE_NAMESPACE, null, WSSE_NAMESPACE);
    $passwordVar = new SoapVar($authToken, XSD_STRING, null,
        WSSE_NAMESPACE, null, WSSE_NAMESPACE);
    $tokenBody = array('Username'=> $usernameVar, 'Password'=> $passwordVar);
    $tokenVar = new SoapVar($tokenBody, SOAP_ENC_OBJECT, null,
        WSSE_NAMESPACE, 'UsernameToken', WSSE_NAMESPACE);
    $securityBody = array('UsernameToken' => $tokenVar);
    $securityVar = new SoapVar($securityBody, SOAP_ENC_OBJECT, null,
        WSSE_NAMESPACE, 'Security', WSSE_NAMESPACE);
    return new SoapHeader(WSSE_NAMESPACE, 'Security',
        $securityVar);
  }

  /**
   * Creates and returns the DFA RequestHeader header element.
   * @param string $namespace the namespace for DFA, version-dependant
   * @param string $applicationName the name of your application
   * @return SoapHeader a complete RequestHeader element
   * @see http://code.google.com/apis/dfa/docs/SOAP_headers.html
   */
  public static function createRequestHeader($namespace, $applicationName) {
    $applicationNameVar = new SoapVar($applicationName, XSD_STRING, null,
        $namespace, null, $namespace);
    $headerBody = array('applicationName'=>$applicationNameVar);
    $headerVar = new SoapVar($headerBody, SOAP_ENC_OBJECT, null, $namespace,
        null, $namespace);
    return new SoapHeader($namespace,'RequestHeader', $headerVar);
  }
}
