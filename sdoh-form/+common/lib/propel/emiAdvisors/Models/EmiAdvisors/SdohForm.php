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

use EmiAdvisors\Base\SdohForm as BaseSdohForm;

/**
 * Skeleton subclass for representing a row from the 'sdoh_form' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class SdohForm extends BaseSdohForm
{
    const LOG_ACTION_SUBMIT = "Submit";
    const LOG_ACTION_CREATE = "CreateForm";
    const LOG_ACTION_USER_DOWNLOAD = "UserDownload";
    const LOG_ACTION_ADMIN_DOWNLOAD = "AdminDownload";
    public function getScreeningRecords(){
        if (is_null($this->getScreeningData()) || $this->getScreeningData() == ""){
            $records = [];
        } else {
            $records = json_decode($this->getScreeningData(), true);
        }
        return $records;
    }
    private $user = null;
    public function getUser($con = null){
        if (is_null($this->user)){
            $this->user = \EmiAdvisors\UserQuery::create()
                ->filterById($this->getUserId())
                ->findOne();
        }
        return $this->user;
    }
    
    public function prepareReference($folder, $record){
        $referenceName = "";

        if (isset($record['referenceType'])){
            if ($record['referenceType'] == 'file' && isset($record['referenceFile']['name']) && isset($record['referenceFile']['identifier'])){
                $referenceName = $record['referenceFile']['name']; $i = 0;
                while (file_exists("$folder/$referenceName")){
                    $referenceName = ($i++) . "-" . $record['referenceFile']['name'];
                }
                copy($this->getFilePath($record['referenceFile']['identifier']), "$folder/$referenceName");
            } else if ($record['referenceType'] == 'url' && isset($record['referenceUrl']) ){
                $referenceName = $record['referenceUrl'];
            }
        }
        return $referenceName;
    }

    public function writeScreeningCSVData($file){
        $meta = [ 'dataValidations' => [] ];

        $user = $this->getUser();
        if (is_null($user)){
            throw new \Exception("Unable to find form related user");
        }
        $writer = new \CsvWriter($file);
        $folder = dirname($file);
        $records = $this->getScreeningRecords();
        $index = 1;
        $title = [];
        $title[] = "id";
        $title[] = "Element Rating";
        $title[] = "Standardized";
        $title[] = "Yes";
        $title[] = "Domain";
        $title[] = "Introduced by";
        $title[] = "Email";
        $title[] = "Title";
        $title[] = "Organization";
        $title[] = "LOINC Panel Code";
        $title[] = "LOINC Panel Name";
        $title[] = "Question Concept";
        $title[] = "Question Instruction";
        $title[] = "Answer Instruction";
        $title[] = "LOINC Question Code";
        $title[] = "LOINC Question Long Name";
        $title[] = "Boolean";
        $title[] = "Number";
        $title[] = "Units";
        $title[] = "Answer Concept";
        $title[] = "LOINC Answer Code";
        $title[] = "SNOMED CT Code";
        $title[] = "SNOMED CT Fully Specified Name";
        $title[] = "Semantic Tab";
        $title[] = "Relevant Screening Tool";
        $title[] = "Reference";
        /**
         * Additional Adjudication columns 26 - 38
         */
        $title[] = "Adjudication Comments";
        $title[] = "Adjudicator Suggested Disposition";
        $title[] = "Sarah Comments";
        $title[] = "Sarah Disposition Recommendation";
        $title[] = "SME 1 Comments ()";
        $title[] = "SME 1 Disposition Recommendation";
        $title[] = "SME 2 Comments ()";
        $title[] = "SME 2 Disposition Recommendation";
        $title[] = "Submission Row Disposition Decision";
        $title[] = "Master Reference";
        $title[] = "Reason Not Added";
        $title[] = "Date";
        $title[] = "Initials";

        $rowCount = 0;

        $writer->WriteLine($title);

        /*
         * Moved Reference from Question to Panel.
         */
        $referenceName = "";
        if (count($records) > 0){
            $referenceName = $this->prepareReference($folder, $records[0]);
        }
        foreach ($records as $record){
//            $referenceName = $this->prepareReference($folder, $record);
            $questionCodes = isset($record['questionCodes']) ? $record['questionCodes'] : [];
            $questionLoincCodes = self::getCodesFromRecord($questionCodes, 'LOINC');
            if (isset($record['answers']) && count($record['answers']) > 0){
                foreach ($record['answers'] as $answer){
                    $recordRow = array_merge($record, $answer);
                    $answerCodes = isset($recordRow['answerCodes']) ? $recordRow['answerCodes'] : [];
                    $answerLoincCodes = self::getCodesFromRecord($answerCodes, 'LOINC');
                    $answerSnomedCtCodes = self::getCodesFromRecord($answerCodes, 'SNOMED_CT');

                    $row = [];
                    $row[] = "S-" . ($index ++);// id
                    $row[] = ""; // "Element Rating";
                    $row[] = ""; // "Standardized";
                    $row[] = ""; // "Yes";
                    $row[] = $this->getDomain(); // "Domain";
                    $row[] = $user->getName(); // "Introduced by";
                    $row[] = $user->getEmail(); // "Email";
                    $row[] = $user->getTitle(); // "Title";
                    $row[] = $user->getOrganization(); // "Organization";
                    $row[] = isset($recordRow['questionPanelCode']['code']) ? $recordRow['questionPanelCode']['code'] : ''; // "LOINC Panel Code";
                    $row[] = ""; // "LOINC Panel Name";
                    $row[] = isset($recordRow['questionText']) ? $recordRow['questionText'] : ''; // "Question Concept";
                    $row[] = isset($recordRow['questionInstruction']) ? $recordRow['questionInstruction'] : ''; // "Question Instruction";
                    $row[] = isset($recordRow['answerInstruction']) ? $recordRow['answerInstruction'] : ''; // "Answer Instruction";
                    $row[] = count($questionLoincCodes) > 0 ? $questionLoincCodes[0]['code'] : ''; // "LOINC Question Code";
                    $row[] = ""; // "LOINC Question Long Name";
                    $row[] = ""; // "Boolean";
                    $row[] = ""; // "Number";
                    $row[] = ""; // "Units";
                    $row[] = isset($recordRow['answerText']) ? $recordRow['answerText'] : ''; // "Answer Concept";
                    $row[] = count($answerLoincCodes) > 0 ? $answerLoincCodes[0]['code'] : ''; // "LOINC Answer Code";
                    $row[] = count($answerSnomedCtCodes) > 0 ? $answerSnomedCtCodes[0]['code'] : ''; // "SNOMED CT Code";
                    $row[] = ""; // "SNOMED CT Fully Specified Name";
                    $row[] = ""; // "Semantic Tab";
                    $row[] = isset($recordRow['screeningTool']) ? $recordRow['screeningTool'] : ''; // "Relevant Screening Tool";
                    $row[] = $referenceName; // "Reference";
//                    $row[] = isset($recordRow['standardized']) ? $recordRow['standardized'] : ''; // "Standardized";
//                    $row[] = isset($recordRow['validated']) ? $recordRow['validated'] : ''; // "Validated";
                    $writer->WriteLine($row);
                    $rowCount++;
                }
            } else {
                // if no anwer, just write question
                $recordRow = $record;
                $row = [];
                $row[] = "S-" . ($index ++);// id
                $row[] = ""; // "Element Rating";
                $row[] = ""; // "Standardized";
                $row[] = ""; // "Yes";
                $row[] = $this->getDomain(); // "Domain";
                $row[] = $user->getName(); // "Introduced by";
                $row[] = $user->getEmail(); // "Email";
                $row[] = $user->getTitle(); // "Title";
                $row[] = $user->getOrganization(); // "Organization";
                $row[] = isset($recordRow['questionPanelCode']['code']) ? $recordRow['questionPanelCode']['code'] : ''; // "LOINC Panel Code";
                $row[] = ""; // "LOINC Panel Name";
                $row[] = isset($recordRow['questionText']) ? $recordRow['questionText'] : ''; // "Question Concept";
                $row[] = isset($recordRow['questionInstruction']) ? $recordRow['questionInstruction'] : ''; // "Question Instruction";
                $row[] = isset($recordRow['answerInstruction']) ? $recordRow['answerInstruction'] : ''; // "Answer Instruction";
                $row[] = count($questionLoincCodes) > 0 ? $questionLoincCodes[0]['code'] : ''; // "LOINC Question Code";
                $row[] = ""; // "LOINC Question Long Name";
                $row[] = ""; // "Boolean";
                $row[] = ""; // "Number";
                $row[] = ""; // "Units";
                $row[] = ''; // "Answer Concept";
                $row[] = ''; // "LOINC Answer Code";
                $row[] = ''; // "SNOMED CT Code";
                $row[] = ""; // "SNOMED CT Fully Specified Name";
                $row[] = ""; // "Semantic Tab";
                $row[] = isset($recordRow['screeningTool']) ? $recordRow['screeningTool'] : ''; // "Relevant Screening Tool";
                $row[] = $referenceName; // "Reference";
//                $row[] = isset($recordRow['standardized']) ? $recordRow['standardized'] : ''; // "Standardized";
//                $row[] = isset($recordRow['validated']) ? $recordRow['validated'] : ''; // "Validated";
                $writer->WriteLine($row);
                $rowCount++;
            }
        }
        $writer->Close();

        if ($rowCount > 0){
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                'cellRange'=>[
                    'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    'firstColumn' => 27, 'lastColumn' =>27
                ]
            ];
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                'cellRange'=>[
                    'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    'firstColumn' => 29, 'lastColumn' =>29
                ]
            ];
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                'cellRange'=>[
                    'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    'firstColumn' => 31, 'lastColumn' =>31
                ]
            ];
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                'cellRange'=>[
                    'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    'firstColumn' => 33, 'lastColumn' =>33
                ]
            ];
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                'cellRange'=>[
                    'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    'firstColumn' => 34, 'lastColumn' =>34
                ]
            ];
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_REASON_NOT_ADDED ),
                'cellRange'=>[
                    'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    'firstColumn' => 36, 'lastColumn' =>36
                ]
            ];
        }
        return $meta;
    }
    const EXCEL_VALIDATION_TYPE_DISPOSITION = "SuggestedDisposition";
    const EXCEL_VALIDATION_TYPE_GOAL_TYPE = "GoalType";
    const EXCEL_VALIDATION_TYPE_INTERVENTION_TYPE = "InterventionType";
    const EXCEL_VALIDATION_TYPE_REASON_NOT_ADDED = "ReasonNotAdded";
    static function getExcelDataValidationValues($validaitoniType){
        if ($validaitoniType == self::EXCEL_VALIDATION_TYPE_DISPOSITION) {
            return ['Add', 'Duplicate', 'Synonymous', 'Park', 'Do not add', 'Info Needed'];
        } else  if ($validaitoniType == self::EXCEL_VALIDATION_TYPE_REASON_NOT_ADDED){
            return ['Other SDOH Domain', 'Out of Scope', 'Withdraw', 'tooGranular'];
        } else  if ($validaitoniType == self::EXCEL_VALIDATION_TYPE_GOAL_TYPE){
            return ['Patient', 'Organization'];
        } else  if ($validaitoniType == self::EXCEL_VALIDATION_TYPE_INTERVENTION_TYPE){
            return ['Assessment', 'Assistance', 'Coordination', 'Counseling', 'Education', 'Evaluation of eligibility', 'Provision', 'Referral'];
        }
        return [];
    }


    public function writeDiagnosesCSVData($file){
        $meta = [ 'dataValidations' => [] ];
        $user = $this->getUser();
        if (is_null($user)){
            throw new \Exception("Unable to find form related user");
        }
        $writer = new \CsvWriter($file);
        $folder = dirname($file);
        $records = $this->getDiagnosesRecords();
        $index = 1;
        $title = [];
        $title[] = "id";
        $title[] = "Domain";
        $title[] = "Introduced by";
        $title[] = "Organization";
        $title[] = "Diagnoses / Assessed Needs";
        $title[] = "SNOMED CT Code";
        $title[] = "SNOMED CT Fully Specified Name";
        $title[] = "Semantic Tab";
        $title[] = "ICD-10-CM Code";
        $title[] = "ICD-10-CM Description";
        $title[] = "Relevant Assessment Tool";
        $title[] = "Reference";
        $title[] = "Definition";

        /**
         * Additional Adjudication columns 13 - 25
         */
        $title[] = "Adjudication Comments";
        $title[] = "Adjudicator Suggested Disposition";
        $title[] = "Sarah Comments";
        $title[] = "Sarah Disposition Recommendation";
        $title[] = "SME 1 Comments ()";
        $title[] = "SME 1 Disposition Recommendation";
        $title[] = "SME 2 Comments ()";
        $title[] = "SME 2 Disposition Recommendation";
        $title[] = "Submission Row Disposition Decision";
        $title[] = "Master Reference";
        $title[] = "Reason Not Added";
        $title[] = "Date";
        $title[] = "Initials";

        $rowCount = 0;
        $writer->WriteLine($title);
        foreach ($records as $record){
            $answerCodes = isset($record['answerCodes']) ? $record['answerCodes'] : [];
            $answerSnomedCtCodes = self::getCodesFromRecord($answerCodes, 'SNOMED_CT');
            $answerIcd10Codes = self::getCodesFromRecord($answerCodes, 'ICD-10');

            $row = [];
            $row[] = "D-" . ($index ++);// id
            $row[] = $this->getDomain(); // "Domain";
            $row[] = $user->getName(); // "Introduced by";
            $row[] = $user->getOrganization(); // "Organization";
            $row[] = isset($record['answerText']) ? $record['answerText'] : ''; // "Diagnosis/Assessed Need";
            $row[] = count($answerSnomedCtCodes) > 0 ? $answerSnomedCtCodes[0]['code'] : ''; // "SNOMED CT Code";
            $row[] = ""; // "SNOMED CT Fully Specified Name";
            $row[] = ""; // "Semantic Tab";
            $row[] = count($answerIcd10Codes) > 0 ? $answerIcd10Codes[0]['code'] : ''; // "ICD-10-CM Code";
            $row[] = ""; // "ICD-10-CM Description";
            $row[] = isset($record['revlevantAssessmentTool']) ? $record['revlevantAssessmentTool'] : ''; // "Relevant Assessment Tool";
            $row[] = $this->prepareReference($folder, $record); // "Reference";
            $row[] = isset($record['definition']) ? $record['definition'] : ''; // "Definition"
            $writer->WriteLine($row);
            $rowCount++;
        }
        $writer->Close();

        if ($rowCount > 0){
            $dispoitionColumns = [14, 16, 18, 20, 21];
            foreach ($dispoitionColumns as $col){
                $meta['dataValidations'][] = [
                    'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                    'cellRange'=>[
                        'firstColumn' => $col, 'lastColumn' =>$col, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    ]
                ];
            }
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_REASON_NOT_ADDED ),
                'cellRange'=>[
                    'firstColumn' => 23, 'lastColumn' =>23, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                ]
            ];
        }

        return $meta;
    }

    public function writeGoalCSVData($file){
        $meta = [ 'dataValidations' => [] ];
        $user = $this->getUser();
        if (is_null($user)){
            throw new \Exception("Unable to find form related user");
        }
        $writer = new \CsvWriter($file);
        $folder = dirname($file);
        $records = $this->getGoalRecords();
        $index = 1;
        $title = [];
        $title[] = "id";
        $title[] = "Domain";
        $title[] = "Introduced by";
        $title[] = "Organization";
        $title[] = "Goal";
        $title[] = "LOINC Code";
        $title[] = "LOINC Long Name";
        $title[] = "Relevant Assessment Tool";
        $title[] = "Reference";
        $title[] = "Definition";

        /**
         * Additional Adjudication columns 10 - 25
         */
        $title[] = "Adjudication Comments";
        $title[] = "Adjudicator Suggested Disposition";
        $title[] = "Sarah Comments";
        $title[] = "Sarah Disposition Recommendation";
        $title[] = "Sarah Goal Type";
        $title[] = "SME 1 Comments ()";
        $title[] = "SME 1 Disposition Recommendation";
        $title[] = "SME 1 Goal Type";
        $title[] = "SME 2 Comments ()";
        $title[] = "SME 2 Disposition Recommendation";
        $title[] = "SME 2 Goal Type";
        $title[] = "Submission Row Disposition Decision";
        $title[] = "Master Reference";
        $title[] = "Reason Not Added";
        $title[] = "Date";
        $title[] = "Initials";

        $rowCount = 0;

        $writer->WriteLine($title);
        foreach ($records as $record){
            $answerCodes = isset($record['answerCodes']) ? $record['answerCodes'] : [];
            $answerLoincCodes = self::getCodesFromRecord($answerCodes, 'LOINC');

            $row = [];
            $row[] = "G-" . ($index ++);// id
            $row[] = $this->getDomain(); // "Domain";
            $row[] = $user->getName(); // "Introduced by";
            $row[] = $user->getOrganization(); // "Organization";
            $row[] = isset($record['answerText']) ? $record['answerText'] : ''; // "Goal";
//            $referenceName = "";
//            if (isset($record['referenceFile']['name']) && isset($record['referenceFile']['identifier'])){
//                $referenceName = $record['referenceFile']['name']; $i = 0;
//                while (file_exists("$folder/$referenceName")){
//                    $referenceName = ($i++) . "-" . $record['referenceFile']['name'];
//                }
//                copy($this->getFilePath($record['referenceFile']['identifier']), "$folder/$referenceName");
//            }
//            $row[] = $referenceName; // "Reference";
            $row[] = count($answerLoincCodes) > 0 ? $answerLoincCodes[0]['code'] : ''; // "LOINC Code";
            $row[] = ""; // "LOINC Long Name";
            $row[] = isset($record['revlevantAssessmentTool']) ? $record['revlevantAssessmentTool'] : ''; // "Relevant Assessment Tool";
            $row[] = $this->prepareReference($folder, $record); // "Reference";
            $row[] = isset($record['definition']) ? $record['definition'] : ''; // "Definition"

            $writer->WriteLine($row);
            $rowCount++;
        }
        $writer->Close();

        if ($rowCount > 0){
            $dispoitionColumns = [11, 13, 16, 19, 21];
            $goalTpyeColumns = [14, 17, 20];
            foreach ($dispoitionColumns as $col){
                $meta['dataValidations'][] = [
                    'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                    'cellRange'=>[
                        'firstColumn' => $col, 'lastColumn' =>$col, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    ]
                ];
            }
            foreach ($goalTpyeColumns as $col){
                $meta['dataValidations'][] = [
                    'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_GOAL_TYPE ),
                    'cellRange'=>[
                        'firstColumn' => $col, 'lastColumn' =>$col, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    ]
                ];
            }
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_REASON_NOT_ADDED ),
                'cellRange'=>[
                    'firstColumn' => 23, 'lastColumn' =>23, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                ]
            ];
        }

        return $meta;
    }

    public function writeInterventionCSVData($file){
        $meta = [ 'dataValidations' => [] ];
        $user = $this->getUser();
        if (is_null($user)){
            throw new \Exception("Unable to find form related user");
        }
        $writer = new \CsvWriter($file);
        $folder = dirname($file);
        $records = $this->getInterventionRecords();
        $index = 1;
        $title = [];
        $title[] = "id";
        $title[] = "Domain";
        $title[] = "Introduced by";
        $title[] = "Organization";
        $title[] = "Definition";
        $title[] = "Interventions Framework Category";
        $title[] = "Intervention";
        $title[] = "Code System";
        $title[] = "Code";
        $title[] = "Code Description";
//        $title[] = "SNOMED CT Fully Specified Name";
        $title[] = "Semantic Tag";
//        $title[] = "CPT Code";
//        $title[] = "CPT Description";
//        $title[] = "HCPCS Code";
//        $title[] = "HCPCS Description";
        $title[] = "Relevant Assessment Tool";
        $title[] = "Reference";

        /**
         * Additional Adjudication columns 13 - 28
         */
        $title[] = "Adjudication Comments";
        $title[] = "Adjudicator Suggested Disposition";
        $title[] = "Sarah Comments";
        $title[] = "Sarah Disposition Recommendation";
        $title[] = "Sarah Intervention Type";
        $title[] = "SME 1 Comments ()";
        $title[] = "SME 1 Disposition Recommendation";
        $title[] = "SME 1 Intervention Type";
        $title[] = "SME 2 Comments ()";
        $title[] = "SME 2 Disposition Recommendation";
        $title[] = "SME 2 Intervention Type";
        $title[] = "Submission Row Disposition Decision";
        $title[] = "Master Reference";
        $title[] = "Reason Not Added";
        $title[] = "Date";
        $title[] = "Initials";

        $rowCount = 0;
        $writer->WriteLine($title);
        foreach ($records as $record){
            $answerCodes = isset($record['answerCodes']) ? $record['answerCodes'] : [];
            $codes = [];
            $answerSnomedCtCodes = self::getCodesFromRecord($answerCodes, 'SNOMED_CT');
            $answerCptCodes = self::getCodesFromRecord($answerCodes, 'CPT');
            $answerHcpcsCodes = self::getCodesFromRecord($answerCodes, 'HCPCS');
            if (count($answerSnomedCtCodes) > 0 && isset( $answerSnomedCtCodes[0]['code'])){
                $codes[] = [ 'system' => 'SNOMED_CT' , 'code' => $answerSnomedCtCodes[0]['code'], 'display' => '' ];
            }
            if (count($answerCptCodes) > 0 && isset( $answerCptCodes[0]['code'])){
                $codes[] = [ 'system' => 'CPT' , 'code' => $answerCptCodes[0]['code'], 'display' => '' ];
            }
            if (count($answerHcpcsCodes) > 0 && isset( $answerHcpcsCodes[0]['code'])){
                $codes[] = [ 'system' => 'HCPCS' , 'code' => $answerHcpcsCodes[0]['code'], 'display' => '' ];
            }
            if (count($codes) === 0){
                // if no code is entered, put empty code
                $codes[] = ['system' => '', 'code' => '', 'display' => ''];
            }
            $recordId = "I-" . ($index ++);
            foreach ($codes as $code){

                $row = [];
                $row[] = $recordId;// id
                $row[] = $this->getDomain(); // "Domain";
                $row[] = $user->getName(); // "Introduced by";
                $row[] = $user->getOrganization(); // "Organization";
                $row[] = isset($record['definition']) ? $record['definition'] : ''; // "Definition"
                $row[] = isset($record['interventionsFrameworkCategory']) ? $record['interventionsFrameworkCategory'] : ''; // "Interventions Framework Category";
                $row[] = isset($record['answerText']) ? $record['answerText'] : ''; // "Intervention";
                $row[] = $code['system']; // "Code System";
                $row[] = $code['code']; // "Code";
                $row[] = $code['display']; // "Code Description";
                $row[] = ""; // "Semantic Tag";
                $row[] = isset($record['revlevantAssessmentTool']) ? $record['revlevantAssessmentTool'] : ''; // "Relevant Assessment Tool";
                $row[] = $this->prepareReference($folder, $record); // "Reference";

                $writer->WriteLine($row);
                $rowCount++;
            }

//            $answerCodes = isset($record['answerCodes']) ? $record['answerCodes'] : [];
//            $answerSnomedCtCodes = self::getCodesFromRecord($answerCodes, 'SNOMED_CT');
//            $answerCptCodes = self::getCodesFromRecord($answerCodes, 'CPT');
//            $answerHcpcsCodes = self::getCodesFromRecord($answerCodes, 'HCPCS');
//
//            $row = [];
//            $row[] = "I-" . ($index ++);// id
//            $row[] = $this->getDomain(); // "Domain";
//            $row[] = $user->getName(); // "Introduced by";
//            $row[] = $user->getOrganization(); // "Organization";
//            $row[] = isset($record['interventionType']) ? $record['interventionType'] : ''; // "Intervention Type";
//            $row[] = isset($record['answerText']) ? $record['answerText'] : ''; // "Intervention";
//            $row[] = count($answerSnomedCtCodes) > 0 ? $answerSnomedCtCodes[0]['code'] : ''; // "SNOMED CT Code";
//            $row[] = ""; // "SNOMED CT Fully Specified Name";
//            $row[] = ""; // "Semantic Tag";
//            $row[] = count($answerCptCodes) > 0 ? $answerCptCodes[0]['code'] : ''; // "CPT Code";
//            $row[] = ""; // "CPT Description";
//            $row[] = count($answerHcpcsCodes) > 0 ? $answerHcpcsCodes[0]['code'] : ''; // "HCPCS Code";
//            $row[] = ""; // "HCPCS Description";
//            $row[] = isset($record['revlevantAssessmentTool']) ? $record['revlevantAssessmentTool'] : ''; // "Relevant Assessment Tool";
//            $row[] = $this->prepareReference($folder, $record); // "Reference";
//            $writer->WriteLine($row);
        }
        $writer->Close();

        if ($rowCount > 0){
            $dispoitionColumns = [14, 16, 19, 22, 24];
            $interventionTpyeColumns = [17, 20, 23];
            foreach ($dispoitionColumns as $col){
                $meta['dataValidations'][] = [
                    'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_DISPOSITION ),
                    'cellRange'=>[
                        'firstColumn' => $col, 'lastColumn' =>$col, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    ]
                ];
            }
            foreach ($interventionTpyeColumns as $col){
                $meta['dataValidations'][] = [
                    'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_INTERVENTION_TYPE ),
                    'cellRange'=>[
                        'firstColumn' => $col, 'lastColumn' =>$col, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                    ]
                ];
            }
            $meta['dataValidations'][] = [
                'values' => self::getExcelDataValidationValues( self::EXCEL_VALIDATION_TYPE_REASON_NOT_ADDED ),
                'cellRange'=>[
                    'firstColumn' => 26, 'lastColumn' =>26, 'firstRow' => 1, 'lastRow' => $rowCount, // exclude first row which is title
                ]
            ];
        }
        return $meta;
    }

    public function getScreeningInfo(){
        return [
            'count' => count($this->getScreeningRecords()),
            'url' => '/form/questions.php?id='. $this->getId(),
            'label' => 'Screening Questions / Answers'
        ];
    }
    public function getDiagnosesRecords(){
        if (is_null($this->getDiagnosesData()) || $this->getDiagnosesData() == ""){
            $records = [];
        } else {
            $records = json_decode($this->getDiagnosesData(), true);
        }
        return $records;
    }
    public function getDiagnosesInfo(){
        return [
            'count' => count($this->getDiagnosesRecords()),
            'url' => '/form/diagnosis.php?id='. $this->getId(),
            'label' => 'Diagnoses'
        ];
    }
    public function getGoalRecords(){
        if (is_null($this->getGoalsData()) || $this->getGoalsData() == ""){
            $records = [];
        } else {
            $records = json_decode($this->getGoalsData(), true);
        }
        return $records;
    }
    public function getGoalInfo(){
        return [
            'count' => count($this->getGoalRecords()),
            'url' => '/form/goal.php?id='. $this->getId(),
            'label' => 'Goals'
        ];
    }
    public function getInterventionRecords(){
        if (is_null($this->getInterventionData()) || $this->getInterventionData() == ""){
            $records = [];
        } else {
            $records = json_decode($this->getInterventionData(), true);
        }
        return $records;
    }
    public function getInterventionInfo(){
        return [
            'count' => count($this->getInterventionRecords()),
            'url' => '/form/intervention.php?id='. $this->getId(),
            'label' => 'Interventions'
        ];
    }

    public function setCurrentSectionData($data){
        switch ($_SERVER['SCRIPT_NAME']){
            case '/form/questions.php':
                $this->setScreeningData($data);
                break;
            case '/form/diagnosis.php':
                $this->setDiagnosesData($data);
                break;
            case '/form/goal.php':
                $this->setGoalsData($data);
                break;
            case '/form/intervention.php':
                $this->setInterventionData($data);
                break;
        }
    }
    public function getCurrentSectionData(){
        $data = "";
        switch ($_SERVER['SCRIPT_NAME']){
            case '/form/questions.php':
                $data = $this->getScreeningData();
                break;
            case '/form/diagnosis.php':
                $data = $this->getDiagnosesData();
                break;
            case '/form/goal.php':
                $data = $this->getGoalsData();
                break;
            case '/form/intervention.php':
                $data = $this->getInterventionData();
                break;
        }
        if (is_null($data) || $data == ""){
            $data = "[]";
        }
        return $data;
    }

    public static function getSectionUrls(){
        return [
            '/form/questions.php', '/form/diagnosis.php', '/form/goal.php', '/form/intervention.php', '/form/view.php'
        ];
    }

    public static function getCurrentSectionIndex(){
        $urls = self::getSectionUrls();
        for ($index = 0; $index < count($urls); $index ++){
            if ($urls[$index] == $_SERVER['SCRIPT_NAME']){
                return $index;
            }
        }
        return -1;
    }

    public function getNextSectionUrl(){
        $urls = self::getSectionUrls();
        $index = self::getCurrentSectionIndex();
        if ($index < count($urls) - 1){
            return $urls[$index + 1] . "?id=" . $this->getId();
        }
        return '';
    }



    public function getPreviousSectionUrl(){
        $urls = self::getSectionUrls();
        $index = self::getCurrentSectionIndex();
        if ($index >0){
            return $urls[$index - 1] . "?id=" . $this->getId();
        }
        return '';
    }

    public function getSteps(){
        return [
            'questions' => $this->getScreeningInfo(),
            'Diagnoses' => $this->getDiagnosesInfo(),
            'goals' => $this->getGoalInfo(),
            'interventions' => $this->getInterventionInfo(),
            'view' => [
                'url' => '/form/view.php?id=' . $this->getId(),
                'label' => 'Review'
            ]
        ];
    }

    public function getFormFolder(){
        global $config;
        if (!isset($config['formFileFolder'])){
            throw new \Exception("Missing configuration parameter formFileFolder");
        }
        $folder = str_replace("#folder#", $this->getId(), $config['formFileFolder']);
        if (file_exists($folder) && is_dir($folder)){

        } else {
            if (!mkdir($folder, 0755, true)){
                throw new \Exception("Unable to create form folder: $folder");
            }
        }
        return $folder;
    }

    public function getFormTmpFolder(){
        $folder = $this->getFormFolder() . "/tmp";
        if (file_exists($folder) && is_dir($folder)){
        } else {
            if (!mkdir($folder, 0755, true)){
                throw new \Exception("Unable to create form folder: $folder");
            }
        }
        return $folder;
    }

    public function getFormFileFolder(){
        $folder = $this->getFormFolder() . "/file";
        if (file_exists($folder) && is_dir($folder)){
        } else {
            if (!mkdir($folder, 0755, true)){
                throw new \Exception("Unable to create form folder: $folder");
            }
        }
        return $folder;
    }

    public function removeFile($identifier){
        $folder = $this->getFormTmpFolder();
        $path = "$folder/$identifier";
        if (file_exists($path) && is_file($path)){
            unlink($path);
        }
    }

    public function getFilePath($identifier){
        if ($this->getStatus() == 'Submitted'){
            $folder = $this->getFormFileFolder();
        } else {
            $folder = $this->getFormTmpFolder();
        }
        return "$folder/$identifier";
    }
    public function downloadFile($identifier, $name, $mimeType){
//        if ($this->getStatus() == 'Submitted'){
//            $folder = $this->getFormFileFolder();
//        } else {
//            $folder = $this->getFormTmpFolder();
//        }
        $path = $this->getFilePath($identifier);
        if (file_exists($path) && is_file($path)){
            $data= file_get_contents($path);
            ob_clean();
            header('Pragma: public');
            header('Cache-Control: public');
            header('Content-Description: File Transfer');
            header("Content-type: $mimeType");
            header('Content-Disposition: attachment; filename="' . $name . '"');
            echo $data;
            exit;
        } else {
            die("File is not found.");
        }
    }
    public function saveFile($path){
        if (!file_exists($path) || !is_file($path)){
            throw new \Exception("No file is found at $path");
        }
        if (!is_readable($path)){
            throw new \Exception("Permission denied to read file $path");
        }
        $folder = $this->getFormTmpFolder();
        $time = time(); $index = 0;
        $identifier = "doc-$time" ;
        while (file_exists("$folder/$identifier")){
            $identifier = "doc-$time-" . (++$index);
        }
        $newPath = "$folder/$identifier";
        if (!copy($path, $newPath)){
            throw new \Exception("Failed to save file to $newPath");
        }

        return $identifier;
    }

    public function submitForm(){
        $this->setStatus('Submitted');
        $tmpFolder = $this->getFormTmpFolder();
        $fileFolder = $this->getFormFileFolder();
        $referenceFiles = [];
        $referenceFiles = array_merge($referenceFiles, self::getFileReferenceFromRecords($this->getScreeningRecords()));
        $referenceFiles = array_merge($referenceFiles, self::getFileReferenceFromRecords($this->getDiagnosesRecords()));
        $referenceFiles = array_merge($referenceFiles, self::getFileReferenceFromRecords($this->getGoalRecords()));
        $referenceFiles = array_merge($referenceFiles, self::getFileReferenceFromRecords($this->getInterventionRecords()));
        foreach ($referenceFiles as $referenceFile){
            $tmpPath = "$tmpFolder/" . $referenceFile['identifier'];
            $targetPath = "$fileFolder/" . $referenceFile['identifier'];
            rename($tmpPath, $targetPath);
        }
        if (strlen($tmpFolder) > 10 && \StringHelper::endsWith($tmpFolder, "/tmp")){ // name check is trying to avoid deleting / or some root folders by incident.
            `rm -rf  $tmpFolder`;
        }
        $this->addLog(self::LOG_ACTION_SUBMIT, "Submitted the form");

    }

    public function deleteForm($con = null){
        $this->setValid(0);
        $formFolder = $this->getFormFolder();
        $this->save($con);
        if (\StringHelper::endsWith($formFolder, '/')){
            $formFolder = substr($formFolder, 0, strlen($formFolder) - 1);
        }
        if (strlen($formFolder) > 20 && \StringHelper::endsWith($formFolder, "/" . $this->getId())){ // name check is trying to avoid deleting / or some root folders by incident.
            `rm -rf  $formFolder`;
        }
        $this->addLog(self::LOG_ACTION_SUBMIT, "Deleted the form");
    }

    public function getFormExportName(){
        $userName = "";
        if (!is_null($user = $this->getUser()) ){
            $userName = $user->getFirstName() . $user->getLastName();
        }
        return sprintf("%s-%s-%s", str_replace(" ", "", $this->getDomain()), $userName, date('Ymd', time()));
    }

    public function addLog($action, $message,  $level = "info"){
        $log = [
            'action' => $action,
            'time' => date('Y-m-d H:i:s', time()),
            'message' => $message,
            'level' => $level
        ];
        $logs = $this->getLogsAsArray();
        $logs[] = $log;
        $this->setLogsAsArray($logs);
        return $log;
    }

    public function getLogsAsArray(){
        $logsText = $this->getLog();
        if (is_null($logsText) || $logsText == ""){
            $logsText = "[]";
        }
        return json_decode($logsText, true);
    }

    public function setLogsAsArray($array){
        $this->setLog(json_encode($array));
    }

    public static function getFileReferenceFromRecords($records){
        $list = [];
        if (!is_null($records) && is_array($records)){
            foreach ($records as $record){
                if (isset($record['referenceFile']['identifier'])){
                    $list[] = $record['referenceFile'];
                }
            }
        }
        return $list;
    }

    public static function getCodesFromRecord($codeSet, $codeSystem){
        $codes = [];
        if (!is_null($codeSet) && count($codeSet) > 0){
            foreach ($codeSet as $code ){
                if ($code['system'] == $codeSystem){
                    $codes[] = $code;
                }
            }
        }
        return $codes;
    }



}
