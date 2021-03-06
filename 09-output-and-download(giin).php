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

date_default_timezone_set('Asia/Tokyo');
require __DIR__ . '/vendor/autoload.php';

//サンプルカードをテンプレートとして指定してみる
$book = PHPExcel_IOFactory::load('templates/sample_card.xlsx');

// 氏名とカナ、タイムスタンプを記載してみる
$sheet = $book->getActiveSheet();
$sheet->setCellValue('D8', 'ヤマダ　タロウ');
$sheet->setCellValue('D10', '山田　太郎');
$sheet->setCellValue('AM6', date("Ymd"));

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="output.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($book, 'Excel2007');
$writer->save('php://output');
