<?php

// ファイルのパス
$filepath = '/tmp/13-tcPDF.pdf';
 
// リネーム後のファイル名
$filename = '13-tcPDF.pdf';
 
// ファイルタイプにPDFを指定
header('Content-Type: application/pdf');
 
// ファイルサイズを取得し、ダウンロードの進捗を表示
header('Content-Length: '.filesize($filepath));
 
// ファイルのダウンロード、リネームを指示
header('Content-Disposition: attachment; filename="'.$filename.'"');
 
// ファイルを読み込みダウンロードを実行
readfile($filepath);