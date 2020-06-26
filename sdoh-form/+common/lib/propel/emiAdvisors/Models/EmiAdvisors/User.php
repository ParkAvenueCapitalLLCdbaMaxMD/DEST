<?php
/**
 * @Desc:
 * @Auth: Yan Wang <ywang@max.md>
 * @Date: 3/18/20
 * @Copy: (c) Copyright 2020 Park Avenue Capital LLC dba MaxMD, All Rights Reserved.
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
namespace EmiAdvisors;

use EmiAdvisors\Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser
{

    public function setUserPassword($rawPassword){
        $salt_length = openssl_cipher_iv_length("aes-256-cbc");
        $salt = bin2hex(openssl_random_pseudo_bytes($salt_length));
        $salted_password = $rawPassword . $salt;
        $hashed_password = hash("sha256", $salted_password);
        $this->setPassword($hashed_password);
        $this->setSalt($salt);
    }
    public function getName(){
        return $this->getFirstName() . " " . $this->getLastName();
        
    }
    public function getActivationEmailContent($activationLink){
        $content = sprintf("<h3>Dear %s,</h3>", $this->getFirstName());
        $content .= "<p>Please open the following link to activate your SDOH Data Element Collection Form account:</p>";
        $content .= "<p><a href='$activationLink'>$activationLink</a> </p>";
        $expireAt = $this->getTokenExpireTs('Y-m-d H:i:s T');
        $content .= "<p>Your token will expire at $expireAt. </p>";
        $content .= "<p>Thank you</p>";
        return $content;
    }

    public function getResetPasswordEmailContent($link){
        $content = "<h3>Dear Customer</h3>";
        $content .= "<p>Please reset your admin password using the following link:</p>";
        $content .= "<p><a href='$link'>$link</a> </p>";
        $expireAt = $this->getTokenExpireTs('Y-m-d H:i:s T');
        $content .= "<p>Your token will expire at $expireAt. </p>";
        return $content;
    }

    public function toJsonArray(){
        $arr = [];
        $arr['id'] = $this->getId();
        $arr['email'] = $this->getEmail();
        $arr['firstName'] = $this->getFirstName();
        $arr['lastName'] = $this->getLastName();
        $arr['role'] = $this->getRole();
        $arr['title'] = $this->getTitle();
        $arr['organization'] = $this->getOrganization();

        return $arr;
    }

    public function toCSVRow(){
        return [
            $this->getName(),
            $this->getTitle(),
            $this->getOrganization(),
            $this->getRole(),
            $this->getEmail()
        ];
    }

    public static function toCSVTitle(){
        return [
            "Name", "Title", "Organization", "Role", "Email"
        ];
    }
}
