<?php


namespace yii2\traits;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

trait ExcelTrait
{
    /**
     * @param $titleFields
     * [
     *  'aa' => '第一列',
     *  'bb.cc' => '第二列'
     * ]
     * @param $items
     * [
     *  ['aa' => '第一行1', 'bb' => ['cc' => '第一行2']]
     *  ['aa' => '第二行1', 'bb' => ['cc' => '第二行2']]
     * ]
     * @param null $fileName
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function export($titleFields, $items, $fileName = null)
    {
        $spreadSheet = new Spreadsheet();

        $activeSheet = $spreadSheet->getActiveSheet();

        $titles = array_values($titleFields);

        //表头 设置单元格内容
        foreach ($titles as $titleIndex => $title) {
            $activeSheet->setCellValueByColumnAndRow($titleIndex + 1, 1, $title);
        }

        $fields = array_keys($titleFields);
        foreach ($items as $rowIndex => $item) {
            foreach ($fields as $columnIndex => $field) {
                $value = data_get($item, $field, '');
                $activeSheet->getCellByColumnAndRow($columnIndex + 1, $rowIndex + 2)->setValueExplicit($value, 's');
            }
        }

        $fileName = ($fileName ? $fileName : uniqid()) . ".xlsx";

        header('Content-Type:application/vnd.ms-excel');
        header("Content-Disposition:attachment;filename=\"{$fileName}\"");
        header('Cache-Control:max-age=0');

        try {
            $writer = IOFactory::createWriter($spreadSheet, 'Xlsx');
            $writer->setPreCalculateFormulas(false);
            $writer->save('php://output');

            $spreadSheet->disconnectWorksheets();//解除内存占用
            unset($spreadSheet);
            unset($activeSheet);
            unset($rowIndex);
            unset($value);
            unset($titles);
            unset($fields);
            unset($writer);
            unset($items);
            unset($titleFields);
            unset($titles);

            exit();
        } catch (\Exception $exception) {
            \Yii::error($exception->getMessage());
            logger_exception('excel.export.error', $exception);
        }
    }
}
