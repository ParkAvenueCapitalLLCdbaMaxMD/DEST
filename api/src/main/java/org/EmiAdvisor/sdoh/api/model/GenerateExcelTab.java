package org.EmiAdvisor.sdoh.api.model;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;
import org.codehaus.enunciate.json.JsonRootType;

import java.util.ArrayList;
import java.util.List;

/**
 * @date: 3/23/20
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
public class GenerateExcelTab {
    private String name;
    private byte[] csvData;
    final private List<ExcelDataValidation> dataValidations = new ArrayList<>();

    public GenerateExcelTab() {
    }

    public GenerateExcelTab(String name, byte[] csvData) {
        this.name = name;
        this.csvData = csvData;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public byte[] getCsvData() {
        return csvData;
    }

    public void setCsvData(byte[] csvData) {
        this.csvData = csvData;
    }

    public List<ExcelDataValidation> getDataValidations() {
        return dataValidations;
    }

    public void setDataValidations(List<ExcelDataValidation> dataValidations) {
        this.dataValidations.clear();
        this.dataValidations.addAll( dataValidations );
    }
}
