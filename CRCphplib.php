<?php
/*
 * This is a PHP library that handles calling Civil Right Defenders Captcha.
 *    - Documentation and latest version
 *          http://captcha.civilrightsdefenders.org
 *
 * Copyright (c) 2013 Civil Right Defenders
 * AUTHORS:
 *   Bärnt & Ärnst, barntarnst.com, par@barntarnst.com
 * 
 * BUGS report to captcha@civilrightsdefenders.org
 *
 *
 */


define("CRC_API_SERVER", "http://captcha.civilrightsdefenders.org/captchaAPI/");
define("CRC_SERVER", "captcha.civilrightsdefenders.org");
define("CRC_PATH", "/captchaAPI/");


class civilrightscaptcha
{
    public $lang = "";
    /*
    *   Call API with get request to get captcha.
    */
    public function show() {
        $view = file_get_contents(CRC_API_SERVER.$this->lang);
        return $view;
    }
    /*
    *   Change language. For current supported languages see wiki at http://www.civilrightdefenders.org/captcha/
    *   If language code is not supported it will be set to english.
    */
    public function setLanguage($lang) {
        $this->lang = "?lang=".$lang;
    }
    /*
    *   Call API with post request to check code.
    */
    public function check($code, $sessid) {
        // debug:
        // $this->sendRequest(CRC_SERVER, CRC_PATH, 'POST', array('code' => $code), $sessid);
        return $this->sendRequest(CRC_SERVER, CRC_PATH, 'POST', array('code' => $code), $sessid) == 'true' ? true : false;
    }
    /*
    *   HTTP Request helper function. Includes the users captcha-id as session variable.
    */
    public function sendRequest( $host, $path, $method = 'GET', $data = array(), $session, $port = 80 )
    {
        $req = http_build_query( $data );
        $http_request  = "$method $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $http_request .= "Content-Length: " . strlen($req) . "\r\n";
        $http_request .= "User-Agent: CAPTCHA/PHP\r\n";
        $http_request .= "Cookie: PHPSESSID=" . $session . "\r\n";
        $http_request .= "\r\n";
        $http_request .= $req;

        $response = '';
        if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
                die ('Could not open socket.');
        }
        fwrite($fs, $http_request);

        while ( !feof($fs) )
                $response .= fgets($fs, 1160); // One TCP-IP packet
        fclose($fs);
        $response = explode("\r\n\r\n", $response, 2);

        return $response[1];
    }
}