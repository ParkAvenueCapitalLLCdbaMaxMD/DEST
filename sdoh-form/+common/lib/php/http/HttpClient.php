<?php
/**
 * @Desc:
 * @Auth: Yan Wang <ywang@max.md>
 * @Date: 4/22/19
 * @Copy: (c) Copyright 2019 MaxMD
 *
 *  Redistribution and use in source and binary forms, with or without  modification,
 *  are permitted provided that the following conditions  are met:
 *
 *  1. Redistributions of source code must retain the above copyright
 *  notice, this list of conditions and the following disclaimer.
 *
 *  2. Redistributions in binary form must reproduce the above copyright
 *  notice, this list of conditions and the following disclaimer in
 *  the documentation and/or other materials provided with the
 *  distribution.
 *
 *  3. Neither the name of the copyright holder nor the names of its
 *  contributors may be used to endorse or promote products derived
 *  from this software without specific prior written permission.
 *
 *  4. Redistributions of any form whatsoever must retain the following
 *  acknowledgment: 'This product includes software developed by
 *  "MaxMD".
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  "AS IS"
 *  AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT  LIMITED TO, THE
 *  IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR  A PARTICULAR PURPOSE
 *  ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  HOLDER OR CONTRIBUTORS BE
 *  LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,  SPECIAL, EXEMPLARY, OR
 *  CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED  TO, PROCUREMENT OF
 *  SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR  PROFITS; OR BUSINESS
 *  INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF  LIABILITY, WHETHER IN
 *  CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING  NEGLIGENCE OR OTHERWISE)
 *  ARISING IN ANY WAY OUT OF THE USE OF THIS  SOFTWARE, EVEN IF ADVISED OF
 *  THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

class HttpHeader{
    public $name;
    public $value;

    /**
     * HttpHeader constructor.
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
    public function toString(){
        return sprintf("%s: %s", $this->name, $this->value);
    }
    public static function parseHeaderLine($line){
        $p = stripos($line, ':');
        if ($p !== false && $p > 0){
            $name = trim(substr($line, 0, $p));
            $value = trim(substr($line, $p+1));
            return new HttpHeader($name, $value);
        }
        return null;
    }
    public static function parseHeaderLines($headerLines){
        $lines = explode("\r\n", $headerLines);
        $headers = [];
        foreach ($lines as $line) {
            $header = self::parseHeaderLine($line);
            if (!is_null($header ) && $header instanceof HttpHeader){
                $headers[] = $header;
            }
        }
        return $headers;
    }

}
class HttpClient
{
    protected $defaultHeaders = []; // array of header line. ex  Content-Type: application/json
    protected $authorizationToken = "";
    protected $tokenType = 'Basic'; //Basic | Bearer
    protected $followRedirect = false;

    protected function generateCurlOptions($httpHeaders = array()){
        $options = array(
            CURLOPT_USERAGENT => 'SDOH Admin REST Client',
            CURLOPT_RETURNTRANSFER => 1,
        );
        if (!is_null($this->authorizationToken) && $this->authorizationToken != "") {
            if (strtolower($this->tokenType) == 'basic'){
                $options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
                $options[CURLOPT_USERPWD] = $this->authorizationToken;
            } else if (strtolower($this->tokenType) == 'bearer'){
                $httpHeaders[] = "Authorization: Bearer " . $this->authorizationToken;
            }
        }
        $headers = [];
        if (count($this->defaultHeaders) > 0){
            $headers = array_merge($headers, $this->defaultHeaders);
        }
        if (count($httpHeaders) > 0){
            $headers = array_merge($headers, $httpHeaders);
        }
        if (count($headers) > 0){
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        $options[CURLOPT_FOLLOWLOCATION] = $this->followRedirect;
//        w($options);exit;
        return $options;
    }

    protected function GET($url, $headers = []){
        $ch = null;
        try{
            $options = $this->generateCurlOptions($headers);
            $options[CURLOPT_URL] = $url;

            $ch = curl_init();
            $flag = curl_setopt_array($ch, $options);

            $output = curl_exec($ch);

            if (curl_error($ch)){
                throw new Exception("Failed to make RESTful call: ". curl_error($ch));
            }
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($code !== 200){
                throw new SdohHttpClientException($code, "HTTP $code . ". $output, $output);
            }

        } catch (Exception $ex){
            if (!is_null($ch)){
                curl_close($ch);
            }
            throw $ex;
        }
        return $output;
    }
    protected function GETAndReturnHeader($url, $headers = []){
        $ch = null;
        try{
            $options = $this->generateCurlOptions($headers);
            $options[CURLOPT_URL] = $url;
            $options[CURLOPT_RETURNTRANSFER] = 1;
            $options[CURLOPT_VERBOSE] = 1;
            $options[CURLOPT_HEADER] = 1;

            $ch = curl_init();
            $flag = curl_setopt_array($ch, $options);

            $output = curl_exec($ch);

            if (curl_error($ch)){
                throw new Exception("Failed to make RESTful call: ". curl_error($ch));
            }
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($code !== 200){
                throw new SdohHttpClientException($code, "HTTP $code . ". $output, $output);
            }

            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//            w("header size: $header_size");
//            w("output:\n");
            $headerLines = substr($output, 0, $header_size);
            $responseHeaders = HttpHeader::parseHeaderLines($headerLines);
            $body = substr($output, $header_size);

            return [
                'headers' => $responseHeaders,
                'content' => $body
            ];
        } catch (Exception $ex){
            if (!is_null($ch)){
                curl_close($ch);
            }
            throw $ex;
        }
    }

    public function POST($url, $requestData, $requestType = "application/json", $requestHeaders = array()){
        $ch = null;
        try{
            $headers = array(
                "Content-Type: $requestType",
                'Content-Length: ' . strlen($requestData)
            );
            if (!is_null($requestHeaders) && is_array($requestHeaders) && count($requestHeaders) > 0){
                $headers = array_merge($headers, $requestHeaders);
            }
            $options = $this->generateCurlOptions($headers);
            $options[CURLOPT_URL] = $url;
            $options[CURLOPT_CUSTOMREQUEST] = 'POST';
            $options[CURLOPT_POSTFIELDS] = $requestData;
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            $output = curl_exec($ch);
            self::validateHttpResponse($ch, $output);
            return $output;
        } catch (Exception $ex){
            if (!is_null($ch)){
                curl_close($ch);
            }
            throw $ex;
        }
        return $output;
    }

    protected function validateHttpResponse($ch, $output = ''){
        if (curl_error($ch)){
            throw new Exception("Failed to make RESTful call: ". curl_error($ch));
        }
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($code !== 200 && $code !== 201){
            throw new SdohHttpClientException($code, "HTTP $code . ". $output, $output);
        }
    }

}