<?php
/**
 * @Desc:
 * @Auth: Yan Wang <ywang@max.md>
 * @Date: 3/18/20
 * @Copy: (c) Copyright 2020 MaxMD
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
class SdohApiHelper{
    public static function badRequest($message){
        $ret = ['error' => $message, 'msg' => ['error' => $message]];

        ob_clean();
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode($ret, JSON_UNESCAPED_SLASHES);

        exit;
    }
    public static function notAuthenticated($message){
        $ret = ['error' => $message, 'msg' => ['error' => $message]];
        ob_clean();
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode($ret, JSON_UNESCAPED_SLASHES);

        exit;
    }

    public static function forbidden($message){
        $ret = ['error' => $message, 'msg' => ['error' => $message]];
        ob_clean();
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode($ret, JSON_UNESCAPED_SLASHES);

        exit;
    }

    public static function getReleaseInfo(){
        global $config;
        $releaseInfo = "v";
        $releasedTime = filemtime("/usr/local/contrib/app/emi-advisors/current/sdoh-form");
        $releasedTimeStr = date('Y-m-d H:i:s T', $releasedTime);
        $releaseInfo .= $config['release'];
        $releaseInfo .= " ($releasedTimeStr)";
        $releaseTitle = $config['release'] . " was released at $releasedTimeStr";
        return [ 'title' => $releaseTitle, 'label' => $releaseInfo, 'version' => $config['release']];
    }

    public static function getAuthorizationHeaderValue(){
        $headers = getallheaders();
        $authorizationValue = "";
        if (!is_null($headers) && isset($headers['Authorization'])){
            $authorizationValue = $headers['Authorization'];
        } else if (!is_null($headers) && isset($headers['authorization'])){
            $authorizationValue = $headers['authorization'];
        }
        return $authorizationValue;
    }
    public static function authenticateBasic($authValue){
        if (stripos($authValue, "basic ") === 0){
            $encoded = trim(substr($authValue, strlen("basic ")));
            $plain = base64_decode($encoded);
            $p = strpos($plain, ':');
            if ($p > 0){
                $username = substr($plain, 0, $p);
                $pwd = substr($plain, $p+1);
                return AuthManager::userLogin($username, $pwd, '', false);
            }
        }
        return false;
    }

    public static function log($message, $level = 'INFO'){
        global $config;
        $file = $config['apiLog'];
        file_put_contents($file, sprintf("%s [%s] %s\n", date('Y-m-d H:i:s'), $level, $message), FILE_APPEND);
    }
}