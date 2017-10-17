<?php
$input_file = isset($input_file) ? $input_file : 'test.pdf';
$remote_file = '/public_html/home.coresv.com/test/output.pdf';

define("FTP_SERVER", getenv("FTP_SERVER"));
define("FTP_ACCOUNT", getenv("FTP_ACCOUNT"));
define("FTP_PASS", getenv("FTP_PASS"));

// 接続を確立する
$conn_id = ftp_connect(FTP_SERVER) or die("Couldn't connect to ") . FTP_SERVER;

// ユーザー名とパスワードでログインする
$login_result = ftp_login($conn_id, FTP_ACCOUNT, FTP_PASS);

//パッシブモードをオンにする
ftp_pasv($conn_id, true);

// ファイルをアップロードする
if (ftp_put($conn_id, $remote_file, $input_file, FTP_BINARY)) {
 echo "successfully uploaded $input_file\n";
} else {
 echo "There was a problem while uploading $input_file\n";
 echo FTP_SERVER . "\n";
}

// 接続を閉じる
ftp_close($conn_id);
?>