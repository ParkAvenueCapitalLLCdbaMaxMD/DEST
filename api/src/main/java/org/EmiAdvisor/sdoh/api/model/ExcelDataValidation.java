package org.EmiAdvisor.sdoh.api.model;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import org.codehaus.enunciate.json.JsonIgnore;
import org.codehaus.enunciate.json.JsonRootType;

import java.util.ArrayList;
import java.util.List;

/**
 * @date: 3/25/20
 * @author: Yan Wang <ywang@max.md>
 * @copy: (C) Copyright 2020 Park Avenue Capital LLC dba MaxMD, All Rights Reserved.
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
 */

@JsonIgnoreProperties(ignoreUnknown = true)
@JsonRootType
public class ExcelDataValidation {
    private ExcelCellRange cellRange;
    final private List<String> values = new ArrayList<>();

    public ExcelDataValidation() {
    }

    public ExcelDataValidation(ExcelCellRange cellRange, List<String> values) {
        this.cellRange = cellRange;
        this.values.addAll(values);
    }

    public ExcelCellRange getCellRange() {
        return cellRange;
    }

    public void setCellRange(ExcelCellRange cellRange) {
        this.cellRange = cellRange;
    }

    public List<String> getValues() {
        return values;
    }

    public void setValues(List<String> values) {
        this.values.clear();
        this.values.addAll(values);
    }

    @JsonIgnore
    public String[] getValuesAsArray(){
        return values.toArray(new String[0]);
    }

    @JsonIgnore
    public String toString(){
        if (cellRange == null){
            return "Range[], Values " + values;
        }
        return String.format("Range[%d, %d, %d, %d], Values %s", cellRange.getFirstRow(), cellRange.getLastRow(), cellRange.getFirstColumn(), cellRange.getLastColumn(), values);
    }

    @JsonIgnore
    public boolean isValid(){
        if (cellRange == null){
            return false;
        }
        if (cellRange.getFirstRow() < 0 || cellRange.getFirstColumn() < 0){
            return false;
        }
        if (cellRange.getFirstColumn() > cellRange.getLastColumn()){
            return  false;
        }
        if (cellRange.getFirstRow() > cellRange.getLastRow() ){
            return false;
        }

        return true;
    }
}
