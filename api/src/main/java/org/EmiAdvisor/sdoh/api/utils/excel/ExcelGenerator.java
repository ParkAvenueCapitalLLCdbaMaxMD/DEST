package org.EmiAdvisor.sdoh.api.utils.excel;

import com.fasterxml.jackson.databind.ObjectMapper;
import org.EmiAdvisor.sdoh.api.controller.ExcelUtilsController;
import org.EmiAdvisor.sdoh.api.exception.FailedToGenerateExcelException;
import org.EmiAdvisor.sdoh.api.model.ExcelDataValidation;
import org.EmiAdvisor.sdoh.api.model.GenerateExcelForm;
import org.EmiAdvisor.sdoh.api.model.GenerateExcelTab;
import org.apache.commons.csv.CSVFormat;
import org.apache.commons.csv.CSVParser;
import org.apache.commons.csv.CSVRecord;
import org.apache.commons.io.FilenameUtils;
import org.apache.commons.io.IOUtils;
import org.apache.commons.lang.StringUtils;
import org.apache.poi.hssf.usermodel.*;
import org.apache.poi.ss.usermodel.*;
import org.apache.poi.ss.util.CellRangeAddressList;
import org.apache.poi.xssf.usermodel.*;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import java.io.*;
import java.util.List;

/**
 * @date: 3/23/20
 * @author: Yan Wang <ywang@max.md>
 * @copy: (C) Copyright 2020 MaxMD Corporation, All Rights Reserved.
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
public class ExcelGenerator {
    private static final Logger LOGGER = LoggerFactory.getLogger(ExcelGenerator.class);

    public static byte[] generateExcel(GenerateExcelForm form) throws FailedToGenerateExcelException {
//        final HSSFWorkbook wb = new HSSFWorkbook();
        final XSSFWorkbook wb = new XSSFWorkbook();

        if (form.isLoadLookupsTab()){
            addLookupsSheet(wb);
        }

        StringBuilder log = new StringBuilder();
        log.append("Generating Excel by form");

        try{
            final CellStyle titleStyle = wb.createCellStyle();
            final CellStyle titleHightlightedStyle = wb.createCellStyle();
            final XSSFFont titleFont= wb.createFont();
            titleFont.setFontHeightInPoints((short)10);
            titleFont.setFontName("Arial");
            titleFont.setBold(true);
            titleFont.setItalic(false);
            titleStyle.setFont(titleFont);
//        style.setFillForegroundColor(color.getIndex());
            titleHightlightedStyle.setFillForegroundColor(IndexedColors.PALE_BLUE.getIndex());
            titleHightlightedStyle.setFillPattern(FillPatternType.SOLID_FOREGROUND);
            titleHightlightedStyle.setFont(titleFont);

            for (GenerateExcelTab tabReq : form.getTabs()) {
    //                System.out.println(filename);

    //                File file = new File(inputFolder + "/" + filename.trim());
                int rowN = 0;
                if (StringUtils.isNotBlank(tabReq.getName()) && tabReq.getCsvData() != null){
                    log.append(String.format(" | Tab[%s] ", tabReq.getName()));
                    final XSSFSheet sheet = wb.createSheet(tabReq.getName());
                    LOGGER.info("New Sheet[" + tabReq.getName() + "] " + sheet);

                    /**
                     * load contraints
                     */
                    final List<ExcelDataValidation> dataValidationModels = tabReq.getDataValidations();
                    if (dataValidationModels != null && !dataValidationModels.isEmpty()){
                        final XSSFDataValidationHelper validationHelper = new XSSFDataValidationHelper(sheet);
                        LOGGER.info("New DVHelper on Sheet[" + tabReq.getName() + "] " + validationHelper);
                        for (ExcelDataValidation validationModel : dataValidationModels){
                            if (validationModel.getCellRange() == null || validationModel.getValues().isEmpty()){
                                continue;
                            }
                            if (!validationModel.isValid()){
                                LOGGER.warn("Invalid Validation[" + validationModel + "], skip it");
                                continue;
                            }
                            DataValidation dataValidation = validationHelper.createValidation(
                                    validationHelper.createExplicitListConstraint(validationModel.getValuesAsArray()),
                                    new CellRangeAddressList(
                                            validationModel.getCellRange().getFirstRow(),
                                            validationModel.getCellRange().getLastRow(),
                                            validationModel.getCellRange().getFirstColumn(),
                                            validationModel.getCellRange().getLastColumn()
                                            )
                            );
                            dataValidation.setSuppressDropDownArrow(true);
                            sheet.addValidationData(dataValidation);
                            LOGGER.info("Loaded DV on Sheet[" + tabReq.getName() + "] " + sheet + ", " + dataValidation);
                            log.append(" | Loaded DataValidation{").append(validationModel).append("}");
                        }
                    }



                    CSVParser csvParser = null;
                    try{
                        csvParser = new CSVParser(new InputStreamReader(new ByteArrayInputStream(tabReq.getCsvData())), CSVFormat.DEFAULT);
                        int rowIndex = 0;
                        for (CSVRecord csvRecord : csvParser){
                            boolean isTitle = rowIndex == 0;
                            XSSFRow row = sheet.createRow(rowIndex ++);
                            for (int col=0; col<csvRecord.size(); col++){
                                XSSFCell cell = row.createCell(col);
                                String value = csvRecord.get(col);
                                if (isTitle){
                                    if (value != null && (
                                            value.startsWith("Sarah ") ||value.startsWith("SME 1 ") ||value.startsWith("SME 2 ")
                                    )){
                                        cell.setCellStyle(titleHightlightedStyle);
                                    } else {
                                        cell.setCellStyle(titleStyle);
                                    }
                                }
                                cell.setCellValue(value);
                            }
                            rowN++;
                        }


                    } catch (IOException ex){
                        LOGGER.error("Failed to generate excel on tab: " + tabReq.getName(), ex);
                    } finally {
                        if (csvParser != null){
                            try {
                                csvParser.close();
                            } catch (IOException e) {
                            }
                        }
                    }

                    log.append(rowN + " rows");
                }
            }

            try{
                ByteArrayOutputStream bos = new ByteArrayOutputStream();
                wb.write(bos);
                wb.close();
                byte[] excelData = bos.toByteArray();
                log.append(" | generated excel with " + excelData.length + " bytes");
                return excelData;
            } catch (IOException ex){
                log.append(" | *** Failed to export Excel spreadsheet to output stream: " + ex.getMessage());
                throw new FailedToGenerateExcelException("Failed to export Excel spreadsheet to output stream", ex);
            }
        } finally {
            LOGGER.info(log.toString());
        }

    }

    static XSSFSheet addLookupsSheet(XSSFWorkbook wb){
        XSSFSheet sheet = wb.createSheet("Lookups");
        sheet.setColumnWidth(0, 10 * 256);
        sheet.setColumnWidth(1, 16 * 256);
        sheet.setColumnWidth(2, 90 * 256);

        sheet.createRow(1).createCell(0).setCellValue("Disposition:");
        String[][] vs = new String[][]{
                new String[]{"Add", "Add to MASTER (new term appropriate for this domain)"},
                new String[]{"Duplicate", "Add to MASTER as a duplicate because it is an exact match (include MASTER Reference in comment)"},
                new String[]{"Synonymous", "Add to MASTER as a duplicate because it is conceptually equivalent (include MASTER Reference in comment)"},
                new String[]{"Park", "Add to PARKING LOT because the term is not relevant to this SDOH domain but may be relevant to another SDH domain"},
                new String[]{"Do not add", "Not relevant to SDOH domains and activities covered by Gravity Project"},
                new String[]{"Info Needed", "On hold because more information is needed from submitter"},
        };
        int rowIndex = 2;
        for (int i=0; i<vs.length; i++, rowIndex++){
            XSSFRow row = sheet.createRow(rowIndex);
            for (int j=0; j<vs[i].length; j++){
                row.createCell(1+j).setCellValue(vs[i][j]);
            }
        }

        rowIndex++;
        sheet.createRow(rowIndex++).createCell(0).setCellValue("Reason not added:");
        vs = new String[][]{
                new String[]{"Other SDOH Domain", "The element is not relevant to this SDOH domain (goes with Park)"},
                new String[]{"Out of Scope", "The element is not relevant to SDOH domains/activities covered by Gravity Project (goes with do not add)"},
                new String[]{"Withdrawn", "The element has been withdrawn by the submitter (goes with do not add)"},
                new String[]{"Too Granular", "The element is relevant to this SDOH domain, but too narrowly defined for activities covered by Gravity Project (goes with do not add)"},
        };
        for (int i=0; i<vs.length; i++, rowIndex++){
            XSSFRow row = sheet.createRow(rowIndex);
            for (int j=0; j<vs[i].length; j++){
                row.createCell(1+j).setCellValue(vs[i][j]);
            }
        }

        rowIndex++;
        sheet.createRow(rowIndex++).createCell(0).setCellValue("Goal Type:");
        vs = new String[][]{
                new String[]{"Patient"},
                new String[]{"Organization"},
        };
        for (int i=0; i<vs.length; i++, rowIndex++){
            XSSFRow row = sheet.createRow(rowIndex);
            for (int j=0; j<vs[i].length; j++){
                row.createCell(1+j).setCellValue(vs[i][j]);
            }
        }

        rowIndex++;
        sheet.createRow(rowIndex++).createCell(0).setCellValue("Intervention Type:");
        vs = new String[][]{
                new String[]{"Assessment"},
                new String[]{"Assistance"},
                new String[]{"Coordination"},
                new String[]{"Counseling"},
                new String[]{"Education"},
                new String[]{"Evaluation of eligibility"},
                new String[]{"Provision"},
                new String[]{"Referral"},
        };
        for (int i=0; i<vs.length; i++, rowIndex++){
            XSSFRow row = sheet.createRow(rowIndex);
            for (int j=0; j<vs[i].length; j++){
                row.createCell(1+j).setCellValue(vs[i][j]);
            }
        }

        return sheet;
    }

    public static void main(String[] args) throws Throwable {
//        t1(args);
//        t2();
//        t3();
        t4();
    }

    public ExcelGenerator() {
    }

    static void t3() throws Throwable{
        XSSFWorkbook workbook = new XSSFWorkbook();
        XSSFSheet sheet = workbook.createSheet("Datatypes in Java");

        Object[][] datatypes = {
                {"Datatype", "Type", "Size(in bytes)"},
                {"int", "Primitive", 2},
                {"float", "Primitive", 4},
                {"double", "Primitive", 8},
                {"char", "Primitive", 1},
                {"String", "Non-Primitive", "No fixed size"}
        };

        int rowNum = 0;
        System.out.println("Creating excel");

        for (Object[] datatype : datatypes) {
            Row row = sheet.createRow(rowNum++);
            int colNum = 0;
            for (Object field : datatype) {
                Cell cell = row.createCell(colNum++);
                if (field instanceof String) {
                    cell.setCellValue((String) field);
                } else if (field instanceof Integer) {
                    cell.setCellValue((Integer) field);
                }
            }
        }

        try {
            FileOutputStream outputStream = new FileOutputStream("/Users/yanwang/test/sdoh/o2.xlsx");
            workbook.write(outputStream);
            workbook.close();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }

        System.out.println("Done");
    }

    static void t4() throws Throwable{
        final XSSFWorkbook wb = new XSSFWorkbook();
        addLookupsSheet(wb);
        final XSSFSheet sheet = wb.createSheet("default");
        XSSFDataValidationHelper validationHelper = new XSSFDataValidationHelper(sheet);
        XSSFRow row = sheet.createRow(0);
        XSSFCell cell = row.createCell(0);
        cell.setCellValue("AAA");
        DataValidation dataValidation = validationHelper.createValidation(
                validationHelper.createExplicitListConstraint(new String[]{
                        "AAA", "BBB", "CCC"
                }),
                new CellRangeAddressList(1,3,1,5 )
        );
        dataValidation.setSuppressDropDownArrow(true);
        sheet.addValidationData(dataValidation);

        CellStyle style = wb.createCellStyle();
        XSSFFont font= wb.createFont();
        font.setFontHeightInPoints((short)10);
        font.setFontName("Arial");
        font.setColor(IndexedColors.WHITE.getIndex());
        font.setBold(true);
        font.setItalic(false);
        style.setFont(font);

        for (short i = 0 ; i<=64; i++){
            XSSFCell c = row.createCell(i+3);
            c.setCellValue(i);
            CellStyle s = wb.createCellStyle();
            s.setFillForegroundColor(i);
            s.setFillPattern(FillPatternType.SOLID_FOREGROUND);
            c.setCellStyle(s);
        }

//        style.setFillForegroundColor(color.getIndex());
        style.setFillForegroundColor(IndexedColors.SKY_BLUE.getIndex());
        style.setFillPattern(FillPatternType.SOLID_FOREGROUND);
        cell.setCellStyle(style);
        CellStyle bgStyle = wb.createCellStyle();


        CellStyle style2 = wb.createCellStyle();
//        style.setFillForegroundColor(color.getIndex());
        style2.setFillForegroundColor(IndexedColors.LIGHT_CORNFLOWER_BLUE.getIndex());
        style2.setFillPattern(FillPatternType.SOLID_FOREGROUND);
        XSSFCell cell11 = sheet.createRow(1).createCell(1);
        cell11.setCellStyle(style2);
        cell11.setCellValue("BBB");


//
//        XSSFSheet sheet2 = wb.createSheet("sheet2");
//        XSSFDataValidationHelper helper2 = new XSSFDataValidationHelper(sheet2);
//        XSSFRow row2 = sheet2.createRow(0);
//        XSSFCell cell2 = row2.createCell(0);
//        cell2.setCellValue("AAA");
//        DataValidation dataValidation2 = validationHelper.createValidation(
//                validationHelper.createExplicitListConstraint(new String[]{
//                        "AAA", "BBB", "CCC"
//                }),
//                new CellRangeAddressList(1,3,1,5 )
//        );
//        dataValidation.setSuppressDropDownArrow(true);
//        sheet2.addValidationData(dataValidation);

        File outF = new File("/Users/yanwang/test/sdoh/dropdown1.xlsx");
        wb.write(new FileOutputStream(outF));
        wb.close();
    }

    static void t2() throws Throwable {
        GenerateExcelForm form =  (new ObjectMapper()).readValue(new File("/Users/yanwang/test/sdoh/r1.json"), GenerateExcelForm.class);
        System.out.println("Loaded form");
        for (GenerateExcelTab tab : form.getTabs()){
            System.out.println("tab: " + tab.getName());
        }
        byte[] excel = generateExcel(form);
        File outF = new File("/Users/yanwang/test/sdoh/o1.xlsx");
        IOUtils.write(excel, new FileOutputStream(outF));
        System.out.println("Exported to " + outF.getAbsolutePath());
    }
    static void t1(String[] args){
        if(args.length != 2) {
            System.err.println("Incorrect number of arguments");
        } else {
            String inputFolder = args[0];
            String fileNameList = args[1];

//            String inputFolder = "/home/cliu/Downloads/csvs";
//            String fileNameList = "Interventions Planned-Completed.csv|Goals.csv";
            String[] fileNameArray = fileNameList.split("\\|");
            File folder = new File(inputFolder);
//            String outputFileName = folder + "/generated.xls";
            File outputFile = new File(folder, "generated.xls");
            final HSSFWorkbook wb = new HSSFWorkbook();
            int fileIndex = 0;
            for (String filename : fileNameArray) {
//                System.out.println(filename);

//                File file = new File(inputFolder + "/" + filename.trim());
                File file = new File(folder, filename.trim());
                if(!file.isDirectory() && FilenameUtils.getExtension(file.getName()).equals("csv")) {
                    String sheetName = file.getName().substring(0, file.getName().length() - 4);
                    final HSSFSheet sheet = wb.createSheet(sheetName);
                    CSVParser csvParser = null;
                    try{
                        csvParser = new CSVParser(new FileReader(file), CSVFormat.DEFAULT);
                        int index = 0;
                        for (CSVRecord csvRecord : csvParser){
                            HSSFRow row = sheet.createRow(index ++);
                            for (int col=0; col<csvRecord.size(); col++){
                                HSSFCell cell = row.createCell(col);
                                cell.setCellValue(csvRecord.get(col));
                            }
                        }


                    } catch (IOException ex){
                        ex.printStackTrace(System.err);
                    } finally {
                        if (csvParser != null){
                            try {
                                csvParser.close();
                            } catch (IOException e) {
                            }
                        }
                    }

                }



                try{
                    wb.write(outputFile);
                    wb.close();
                } catch (IOException ex){
                    ex.printStackTrace(System.err);
                }
            }
        }
    }
}
