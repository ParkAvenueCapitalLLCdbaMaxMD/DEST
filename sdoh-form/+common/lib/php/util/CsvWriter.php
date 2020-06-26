<?php
/**
 * @Desc:
 * @Auth: Yan Wang <ywang@max.md>
 * @Date: 5/31/19
 * @Copy: (c) Copyright 2019 Park Avenue Capital LLC dba MaxMD, All Rights Reserved.
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

class CsvWriterException extends Exception{};

class CsvWriter{
    private $csvSpliter = ",";
    private $csvQuote = '"';
    private $handler = null;
    private $lineBreak = "\r\n";
    private $writeToFile = false;
    private $data;

    function __construct($filename, $spliter = ",", $quote = '"') {
        $this->writeToFile = isset($filename) && !is_null($filename);
        if ($this->writeToFile ){
            $this->handler = fopen($filename, "w");
            if (!$this->handler)
                throw new CsvWriterException("Failed to open file: " . $filename);
        } else{
            $this->data = "";
        }

        $this->csvSpliter = $spliter;
        $this->csvQuote = $quote;
    }

    function __destruct() {
        $this->clear();
    }

    public function Close(){
        if ($this->writeToFile ){
            if (!is_null($this->handler)){
                fclose($this->handler);
                $this->handler = null;
            }
        }
    }
    public function clear(){
        $this->Close();
        $this->data = null;
    }

    public function WriteLine($arr = null){
        $items = array();
        if (is_null($arr) || count($arr) === 0){
            $items[] = "";
        } else{
            for ($i=0; $i<count($arr); $i++){
//                $v = str_replace($this->csvQuote, "\\".$this->csvQuote, $arr[$i]);
                $v = str_replace($this->csvQuote, $this->csvQuote.$this->csvQuote, $arr[$i]);
                $items[] = $this->csvQuote . $v . $this->csvQuote;
            }
        }
        $line = join($this->csvSpliter, $items) . $this->lineBreak;
        if ($this->writeToFile){
            $writeSucc = fwrite($this->handler, $line);
        } else{
            $this->data .= $line;
        }
    }

    public function getData(){
        return $this->data;
    }

}