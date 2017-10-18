<?php
/*
 * PHPビルトインサーバで起動します:
 *
 * ```
 * php -S 0.0.0.0:9000 09-output-and-download.php
 * ```
 *
 * お使いのブラウザで http://localhost:9000 を開くとExcelがダウンロードできます
 */

 ini_set('memory_limit', '1024M');
 date_default_timezone_set('Asia/Tokyo');
require __DIR__ . '/vendor/autoload.php';

//サンプルカードをテンプレートとして指定してみる
$book = PHPExcel_IOFactory::load('templates/sample_list.xls');

// 氏名とカナ、タイムスタンプを記載してみる
$sheet = $book->getActiveSheet();

$i = 0;
while ($i < 3001){

    $no = 4 + $i * 3;

    $sheet->setCellValue('A'.$no , $i);
    $sheet->setCellValue('B'.$no , 'AAAA');
    $sheet->setCellValue('C'.$no , 'BBBB');
    $sheet->setCellValue('D'.$no , 'CCCC');
    $sheet->setCellValue('E'.$no , 'DDDD');
    $sheet->setCellValue('F'.$no , 'EEEE');
    $sheet->setCellValue('G'.$no , 'FFFF');
    $sheet->setCellValue('H'.$no , 'GGGG');
    $sheet->setCellValue('I'.$no , 'HHHH');
    $sheet->setCellValue('J'.$no , 'IIII');

    $i++;
}

//error_reporting(0);

//header('Content-Type: application/pdf');
//header('Content-Disposition: attachment;filename="output.pdf"');
//header('Cache-Control: max-age=0');

//エラーを補足して出力する
try {
    // mPDF
    PHPExcel_Settings::setPdfRenderer(
        PHPExcel_Settings::PDF_RENDERER_MPDF,
        __DIR__ .'/vendor/mpdf/mpdf'
    );
    $writer = PHPExcel_IOFactory::createWriter($book, 'PDF');
    //$writer->save('output/13-tcPDF' . strval(ceil(microtime(true)*1000)) . '.pdf');
    //$writer->save('output/13-tcPDF.pdf');
    $writer->save('/tmp/13-tcPDF.pdf');
    //$writer->save('php://output');

    file_put_contents('/tmp/tmp.txt', 'test', FILE_APPEND | LOCK_EX);
    require 'fileupload/ls.php';

} catch (Exception $e) {
    echo 'Catchした例外: ',  $e->getMessage(), "\n";
}


/*
// tcPDF
PHPExcel_Settings::setPdfRenderer(
    PHPExcel_Settings::PDF_RENDERER_TCPDF,
    __DIR__ .'/vendor/tecnickcom/tcpdf'
);
$pdfWriter = PHPExcel_IOFactory::createWriter($book, 'PDF');
$pdfWriter->save('output/13-tcPDF.pdf');
*/