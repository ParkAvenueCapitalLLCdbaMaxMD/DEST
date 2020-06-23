<?php
/**
 * @Desc:
 * @Auth: Yan Wang <ywang@max.md>
 * @Date: 3/25/20
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

class SdohApiClient extends HttpClient {
    protected $apiEndpoint;

    public function __construct($apiEndpoint)
    {
        while (!is_null($apiEndpoint) && strlen($apiEndpoint)  > 0 && substr($apiEndpoint, strlen($apiEndpoint) - 1) == '/' ){
            $apiEndpoint = substr($apiEndpoint, 0, strlen($apiEndpoint) - 1); // remove ending '/'
        }
        $this->apiEndpoint = $apiEndpoint;
    }

    public function generateExcelByForm($form){
        $url = sprintf("%s/api/utils/excel/generate", $this->apiEndpoint);
        $requestContent = json_encode($form, JSON_UNESCAPED_SLASHES);
        return $this->POST($url, $requestContent, "application/json", []);

    }

}