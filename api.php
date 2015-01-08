<?php

class FatSecretAPI {

    static public $base = 'http://platform.fatsecret.com/rest/server.api?';

    /* Private Data */
    private $_consumerKey;
    private $_consumerSecret;

    /* Constructors */

    function FatSecretAPI($consumerKey, $consumerSecret) {
        $this->_consumerKey = $consumerKey;
        $this->_consumerSecret = $consumerSecret;
        return $this;
    }

    /* Properties */

    function GetKey() {
        return $this->_consumerKey;
    }

    function SetKey($consumerKey) {
        $this->_consumerKey = $consumerKey;
    }

    function GetSecret() {
        return $this->_consumerSecret;
    }

    function SetSecret($consumerSecret) {
        $this->_consumerSecret = $consumerSecret;
    }

    /* Public Methods */
    /* Create a new profile with a user specified ID
     * @param userID {string} Your ID for the newly created profile (set to null if you are not using your own IDs)
     * @param token {string} The token for the newly created profile is returned here
     * @param secret {string} The secret for the newly created profile is returned here
     */

    function ProfileCreate($userID, &$token, &$secret) {
        $url = FatSecretAPI::$base . 'method=profile.create';

        if (!empty($userID)) {
            $url = $url . '&user_id=' . $userID;
        }

        $oauth = new OAuthBase();

        $normalizedUrl;
        $normalizedRequestParameters;

        $signature = $oauth->GenerateSignature($url, $this->_consumerKey, $this->_consumerSecret, null, null, $normalizedUrl, $normalizedRequestParameters);

        $doc = new SimpleXMLElement($this->GetQueryResponse($normalizedUrl, $normalizedRequestParameters . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature)));

        $this->ErrorCheck($doc);

        $token = $doc->auth_token;
        $secret = $doc->auth_secret;
    }

    /* Get the auth details of a profile
     * @param userID {string} Your ID for the profile
     * @param token {string} The token for the profile is returned here
     * @param secret {string} The secret for the profile is returned here
     */

    function ProfileGetAuth($userID, &$token, &$secret) {
        $url = FatSecretAPI::$base . 'method=profile.get_auth&user_id=' . $userID;

        $oauth = new OAuthBase();

        $normalizedUrl;
        $normalizedRequestParameters;

        $signature = $oauth->GenerateSignature($url, $this->_consumerKey, $this->_consumerSecret, null, null, $normalizedUrl, $normalizedRequestParameters);

        $doc = new SimpleXMLElement($this->GetQueryResponse($normalizedUrl, $normalizedRequestParameters . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature)));

        $this->ErrorCheck($doc);

        $token = $doc->auth_token;
        $secret = $doc->auth_secret;
    }

    /* Create a new session for JavaScript API users
     * @param auth {array} Pass user_id for your own ID or the token and secret for the profile. E.G.: array(user_id=>"user_id") or array(token=>"token", secret=>"secret")
     * @param expires {int} The number of minutes before a session is expired after it is first started. Set this to 0 to never expire the session. (Set to any value less than 0 for default)
     * @param consumeWithin {int} The number of minutes to start using a session after it is first issued. (Set to any value less than 0 for default)
     * @param permittedReferrerRegex {string} A domain restriction for the session. (Set to null if you do not need this)
     * @param cookie {bool} The desired session_key format
     * @param sessionKey {string} The session key for the newly created session is returned here
     */

    function ProfileRequestScriptSessionKey($auth, $expires, $consumeWithin, $permittedReferrerRegex, $cookie, &$sessionKey) {
        $url = FatSecretAPI::$base . 'method=profile.request_script_session_key';

        if (!empty($auth['user_id'])) {
            $url = $url . '&user_id=' . $auth['user_id'];
        }

        if ($expires > -1) {
            $url = $url . '&expires=' . $expires;
        }

        if ($consumeWithin > -1) {
            $url = $url . '&consume_within=' . $consumeWithin;
        }

        if (!empty($permittedReferrerRegex)) {
            $url = $url . '&permitted_referrer_regex=' . $permittedReferrerRegex;
        }

        if ($cookie == true)
            $url = $url . "&cookie=true";

        $oauth = new OAuthBase();

        $normalizedUrl;
        $normalizedRequestParameters;

        $signature = $oauth->GenerateSignature($url, $this->_consumerKey, $this->_consumerSecret, $auth['token'], $auth['secret'], $normalizedUrl, $normalizedRequestParameters);

        $doc = new SimpleXMLElement($this->GetQueryResponse($normalizedUrl, $normalizedRequestParameters . '&' . OAuthBase::$OAUTH_SIGNATURE . '=' . urlencode($signature)));

        $this->ErrorCheck($doc);

        $sessionKey = $doc->session_key;
    }

    /* Private Methods */

    private function GetQueryResponse($requestUrl, $postString) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }

    private function ErrorCheck($doc) {
        if ($doc->getName() == 'error') {
            throw new FatSecretException((int) $doc->code, $doc->message);
        }
    }

}

class FatSecretException extends Exception {

    public function FatSecretException($code, $message) {
        parent::__construct($message, $code);
    }

}

/* OAuth */

class OAuthBase {
    /* OAuth Parameters */

    static public $OAUTH_VERSION_NUMBER = '1.0';
    static public $OAUTH_PARAMETER_PREFIX = 'oauth_';
    static public $XOAUTH_PARAMETER_PREFIX = 'xoauth_';
    static public $PEN_SOCIAL_PARAMETER_PREFIX = 'opensocial_';
    static public $OAUTH_CONSUMER_KEY = 'oauth_consumer_key';
    static public $OAUTH_CALLBACK = 'oauth_callback';
    static public $OAUTH_VERSION = 'oauth_version';
    static public $OAUTH_SIGNATURE_METHOD = 'oauth_signature_method';
    static public $OAUTH_SIGNATURE = 'oauth_signature';
    static public $OAUTH_TIMESTAMP = 'oauth_timestamp';
    static public $OAUTH_NONCE = 'oauth_nonce';
    static public $OAUTH_TOKEN = 'oauth_token';
    static public $OAUTH_TOKEN_SECRET = 'oauth_token_secret';
    protected $unreservedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.~';

    function GenerateSignature($url, $consumerKey, $consumerSecret, $token, $tokenSecret, &$normalizedUrl, &$normalizedRequestParameters) {
        $signatureBase = $this->GenerateSignatureBase($url, $consumerKey, $token, 'POST', $this->GenerateTimeStamp(), $this->GenerateNonce(), 'HMAC-SHA1', $normalizedUrl, $normalizedRequestParameters);
        $secretKey = $this->UrlEncode($consumerSecret) . '&' . $this->UrlEncode($tokenSecret);
        return base64_encode(hash_hmac('sha1', $signatureBase, $secretKey, true));
    }

    private function GenerateSignatureBase($url, $consumerKey, $token, $httpMethod, $timeStamp, $nonce, $signatureType, &$normalizedUrl, &$normalizedRequestParameters) {
        $parameters = array();

        $elements = explode('?', $url);
        $parameters = $this->GetQueryParameters($elements[1]);

        $parameters[OAuthBase::$OAUTH_VERSION] = OAuthBase::$OAUTH_VERSION_NUMBER;
        $parameters[OAuthBase::$OAUTH_NONCE] = $nonce;
        $parameters[OAuthBase::$OAUTH_TIMESTAMP] = $timeStamp;
        $parameters[OAuthBase::$OAUTH_SIGNATURE_METHOD] = $signatureType;
        $parameters[OAuthBase::$OAUTH_CONSUMER_KEY] = $consumerKey;

        if (!empty($token)) {
            $parameters[OAuthBase::$OAUTH_TOKEN] = $token;
        }

        $normalizedUrl = $elements[0];
        $normalizedRequestParameters = $this->NormalizeRequestParameters($parameters);

        return $httpMethod . '&' . UrlEncode($normalizedUrl) . '&' . UrlEncode($normalizedRequestParameters);
    }

    private function GetQueryParameters($paramString) {
        $elements = split('&', $paramString);
        $result = array();
        foreach ($elements as $element) {
            list($key, $token) = split('=', $element);
            if ($token)
                $token = urldecode($token);
            if (!empty($result[$key])) {
                if (!is_array($result[$key]))
                    $result[$key] = array($result[$key], $token);
                else
                    array_push($result[$key], $token);
            } else
                $result[$key] = $token;
        }

        return $result;
    }

    private function NormalizeRequestParameters($parameters) {
        $elements = array();
        ksort($parameters);

        foreach ($parameters as $paramName => $paramValue) {
            array_push($elements, $this->UrlEncode($paramName) . '=' . $this->UrlEncode($paramValue));
        }
        return join('&', $elements);
    }

    private function UrlEncode($string) {
        $string = urlencode($string);
        $string = str_replace('+', '%20', $string);
        $string = str_replace('!', '%21', $string);
        $string = str_replace('*', '%2A', $string);
        $string = str_replace('\'', '%27', $string);
        $string = str_replace('(', '%28', $string);
        $string = str_replace(')', '%29', $string);
        return $string;
    }

    private function GenerateTimeStamp() {
        return time();
    }

    private function GenerateNonce() {
        return md5(uniqid());
    }

}

$consumer_key = "d14d29bb1adb4881baf4eb67bc9fe786";
$secret_key = "a81fff61c04d4d8fac872e2fc5cf4c44";

$API = new FatSecretAPI($consumer_key, $secret_key);
$call = $API->ProfileRequestScriptSessionKey("foods.search", $auth, null, null, null, false, $sessionKey);



echo "<pre>";
print_r($call);
echo "</pre>";
exit;

exit;

//Signature Base String
//<HTTP Method>&<Request URL>&<Normalized Parameters>
$base = rawurlencode("GET") . "&";
$base .= "http%3A%2F%2Fplatform.fatsecret.com%2Frest%2Fserver.
api&";

//sort params by abc....necessary to build a correct unique signature
$params = "method=foods.search&";
$params .= "oauth_consumer_key=$consumer_key&"; // ur consumer key
$params .= "oauth_nonce=123&";
$params .= "oauth_signature_method=HMAC-SHA1&";
$params .= "oauth_timestamp=" . time() . "&";
$params .= "oauth_version=1.0&";
$params .= "search_expression=" . urlencode($_GET['pasVar']);
$params2 = rawurlencode($params);
$base .= $params2;

//encrypt it!
$sig = base64_encode(hash_hmac('sha1', $base, "$secret_key&", true)); // replace xxx with Consumer Secret
//now get the search results and write them down
$url = "http://platform.fatsecret.com/rest/server.api?" .
        $params . "&oauth_signature=" . rawurlencode($signature);

function loadFoods($url) {

    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, $url);

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    $error = curl_error($ch);

    $info = curl_getinfo($ch);
    // close curl resource to free up system resources
    curl_close($ch);

    return array($output, $error, $info);
}

//$food_feed = file_get_contents($url);
list($output, $error, $info) = loadFoods($url);

echo "<pre>";
print_r($output);
echo "</pre>";
exit;
?>