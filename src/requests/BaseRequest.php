<?php

namespace mipotech\doxi\requests;

abstract class BaseRequest
{
    /**
     * @var bool whether debug mode is enabled or not
     * When debug is enabled, verbose API call info will be
     * outputted to STDOUT.
     */
    public $debug = false;
    /**
     * @var string
     */
    protected $baseEndpoint;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $auth_token;

    /**
     * Construct the class with the API credentials
     *
     * @param string $username
     * @param string $password
     */
    function __construct(string $loginEndpoint, string $baseEndpoint, string $username, string $password)
    {
        $this->loginEndpoint = $loginEndpoint;
        $this->baseEndpoint = $baseEndpoint;
        $this->username = $username;
        $this->password = $password;
		if(isset($_COOKIE["doxi_token"]) && $_COOKIE["doxi_token"]){
			$this->auth_token = $_COOKIE["doxi_token"];
		}
		else {
			$res = $this->login();
			$this->auth_token = $res['access_token'];
			setcookie("doxi_token",$res['access_token'],(time() + $res['expires_in']),'/','',1,1);
		}
    }

    /**
     * Login and Save auth_token
     *
     * @return string
     */
    public function login(): array
    {
		$login_data = ["grant_type" => "password", "username" => $this->username, "password" => $this->password, "client_id" => "doxi"];
		$res = $this->execute(1,$login_data);
		return $res;
    }
	
    /**
     * Return the content type for this function
     *
     * @return string
     */
    public function getContentType(): string
    {
        return 'application/json';
    }
    /**
     * Return the relative endpoint for the API function
     *
     * @return string
     */
    abstract public function getEndpoint(): string;
    /**
     * Return the method for this API function
     *
     * @return string may return GET or POST
     */
    abstract public function getMethod(): string;

    /**
     * Perform the actual API request
     *
     * @return mixed may return an array, null
     */
    public function execute($login=false,$postdata=[])
    {
        $result = [];
        $url = $this->buildFinalEndpoint($login);
        $ch = curl_init($url);
        $headers = [];
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ]);
        if ($this->debug) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
        }
        if ($login || strtoupper($this->getMethod()) == 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, ($login ? http_build_query($postdata) : json_encode($this->buildPostDataArr())));
            $headers[] = 'Content-type: ' . ($login ? 'application/x-www-form-urlencoded' : $this->getContentType());
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
            'Authorization: Bearer '.$this->auth_token,
            'X-Tenant: uti',
            'Accept: application/json',
        ], $headers));
        $res = curl_exec($ch);
        if ($this->debug) {
            if ($res === FALSE) {
                printf("cUrl error (#%d): %s<br>\n", curl_errno($ch), htmlspecialchars(curl_error($ch)));
            }
            rewind($verbose);
            $verboseLog = stream_get_contents($verbose);
            echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
        }
        $responseCode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $contentType = preg_replace('/;.*$/', '', $contentType);
        if ($responseCode < 300) {
            switch ($contentType) {
                case 'application/pdf':
                    $result = $res;
                    break;
                case 'application/json':
                    $result = json_decode($res, true);
                    break;
                default:
                    $result = $res;     // return the response as-is
                    break;
            }
        }
        curl_close($ch);
        return $result;
    }

    /**
     * Build the final API endpoint
     *
     * @return string
     */
    protected function buildFinalEndpoint($login): string
    {
        $url = ($login ? $this->loginEndpoint : $this->baseEndpoint). '/' . ($login ? 'token' : $this->getEndpoint());
        if (!$login && strtoupper($this->getMethod()) === 'GET') {
            $url .= '?' . http_build_query($this->buildPostDataArr());
        }
        return $url;
    }

    /**
     * @return array
     */
    protected function buildPostDataArr(): array
    {
        $postData = get_object_vars($this);
        $omitFields = [
            'debug',
            'loginEndpoint',
            'baseEndpoint',
            'username',
            'password',
        ];
        foreach ($omitFields as $field) {
            if (isset($postData[$field])) {
                unset($postData[$field]);
            }
        }
        return $postData;
    }
}
