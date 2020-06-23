<?php
/**
 * @Desc:
 * @Auth: Yan Wang <ywang@max.md>
 * @Date: 5/28/19
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

class AuthManager {
    public static function getAuthenticatedUser($redirectToLoginPage = false){
        $user = null;
        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1 && isset($_SESSION['username'])){
            $user = \EmiAdvisors\UserQuery::create()
                ->filterByEmail($_SESSION['username'])
                ->filterByValid(1)
                ->filterByActive(1)
                ->findOne();
        }
        if (is_null($user) && $redirectToLoginPage){
            header("Location: /auth/?url=" . urlencode($_SERVER['REQUEST_URI']) );
            exit;
        }
        return $user;
    }


    public static function userLogin($username, $password, $url = '', $redirect = true){
        $user = \EmiAdvisors\UserQuery::create()
            ->filterByActive(1)
            ->filterByValid(1)
            ->filterByEmail($username)
            ->findOne();
        $authenticated = false;
        if (!is_null($user)){
            $salt = $user->getSalt();
            $salted_password = $password.$salt;
            $hashed_password = hash("sha256", $salted_password);
            if ($user->getPassword() == $hashed_password){
                self::authenticated($user, $url, $redirect);
                $authenticated = true;
            }
        }
        return $authenticated;
    }

    public static function authenticated(\EmiAdvisors\User $user, $url = '', $redirect  = true){
        $_SESSION['auth'] = 1;
        $_SESSION['username'] = $user->getEmail();
        $_SESSION['userId'] = $user->getId();
        $_SESSION['userRole'] = $user->getRole();
        if ($redirect){
           self::redirectForAuthenticatedUser($user, $url);
        }
    }

    public static function redirectForAuthenticatedUser(\EmiAdvisors\User $user, $url = ''){
        if ($url == ""){
            switch ($_SESSION['userRole']) {
                case "User":
                    $url = "/form/";
                    break;
                case "Admin":
                    $url = "/admin/";
                    break;
                default:
                    $url = "/form/";
                    break;
            }
        }
        header("Location: $url");
        exit;
    }


}