<?php

namespace mipotech\doxi\requests;

abstract class BaseRequest
{
    const BASE_ENDPOINT = 'https://cloud.doxi.co.il/Pumpi/DoxiAPI/ExternalDoxiAPI';

    /**
     * @var bool whether debug mode is enabled or not
     * When debug is enabled, verbose API call info will be
     * outputted to STDOUT.
     */
    public $debug = false;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $username;

    /**
     * Construct the class with the API credentials
     *
     * @param string $username
     * @param string $password
     */
    function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
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
     * @return array
     */
    public function execute(): array
    {
        $result = [];
        $url = $this->buildFinalEndpoint();
        $ch = curl_init($url);
        $headers = [
            'Accept: application/json',
        ];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        if ($this->debug) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);
        }
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        if (strtoupper($this->getMethod()) == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->buildPostDataArr()));
            $headers[] = 'Content-type: application/json';
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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
        if ($responseCode < 300) {
            $result = json_decode($res, true);
        }
        curl_close($ch);
        return $result;
    }

    /**
     * Build the final API endpoint
     *
     * @return string
     */
    protected function buildFinalEndpoint(): string
    {
        $url = static::BASE_ENDPOINT . '/' . $this->getEndpoint();
        if (strtoupper($this->getMethod()) === 'GET') {
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
        unset($postData['debug']);
        return $postData;
    }
}
