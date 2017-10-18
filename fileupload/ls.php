<body>
<table border="1">
<tr>
<th>ファイル名</th>
<th>サイズ</th>
<th>最終アクセス日</th>
<th>最終更新日</th>
</tr>
<?php
clearstatcache();
$place = '/tmp/';
$dir = opendir($place);
while($file = readdir($dir)){
    
    print('<tr>');
    print('<td><a href="' . $place . $file . '">' . $file . '</a></td>');
    print('<td>' . filesize($place . $file) . '</td>');
    print('<td>' . date('Y/m/d H:i:s', fileatime($place . $file)) . '</td>');
    print('<td>' . date('Y/m/d H:i:s', filemtime($place . $file)) . '</td>');
    print('</tr>');

}
closedir($dir);
?>
</table>
</body>