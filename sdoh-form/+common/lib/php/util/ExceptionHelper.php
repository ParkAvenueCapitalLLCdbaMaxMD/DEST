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
class ExceptionHelper {
    public static function GetExceptionDetails(Exception $ex, $maxTraceDepth=10, $lineSplit = "<br/>", $tab="&nbsp;&nbsp;&nbsp;&nbsp;"){
        if (is_null($ex)){
            return "";
        }
        $line = $ex->getLine();
        $file = $ex->getFile();
        $traceArr = $ex->getTrace();
        $traces = [];
        if (!is_null($traceArr) && count($traceArr) > 0){
            for ($i=0; $i<$maxTraceDepth && $i < count($traceArr); $i++){
                $traceFunction = $traceArr[$i]['function'];
                if (isset($traceArr[$i]['type']) && isset($traceArr[$i]['class'])){
                    $traceType = $traceArr[$i]['type'];
                    $traceClass = $traceArr[$i]['class'];
                    $funcStr = $traceClass . $traceType . $traceFunction . "(";
                    for ($j=0; $j<count($traceArr[$i]['args']); $j++){
                        if ($j > 0){
                            $funcStr .= ", ";
                        }
                        $funcStr .= '$'.$j;
                    }
                    $funcStr .= ")";
                } else{
                    $funcStr = "";
                }
                $traces[] = $tab . "at $file $funcStr : $line ";

                $file = $traceArr[$i]['file'];
                $line = $traceArr[$i]['line'];
            }
        } else{
            $traces[] = " at $file : $line ";
        }
        if ($lineSplit == "<br/>"){
            $error = "<strong>" . $ex->getMessage() . "</strong>";
        } else {
            $error = $ex->getMessage() . ": ";
        }
        $error.= $lineSplit . implode($lineSplit, $traces);

        if (!is_null($ex->getPrevious())){
            $error .= $lineSplit . $lineSplit . "Caused By " . self::GetExceptionDetails($ex->getPrevious());
        }
        return $error;
    }
}