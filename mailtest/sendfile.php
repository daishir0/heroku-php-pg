<?php
$input_file = isset($input_file) ? $input_file : 'test.pdf';

define("ADMIN_MAIL", getenv("ADMIN_MAIL"));

$boundary = "__BOUNDARY__";

$additional_headers = "Content-Type: multipart/mixed;boundary=\"" . $boundary . "\"\n";
$additional_headers .= "From: test@example.com";

$message = "--" . $boundary . "\n";

$message .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\n\n";
$message .= "これはメール添付用のテストメールです。\n";

$message .= "--" . $boundary . "\n";

$message .= "Content-Type: " . mime_content_type($filetype) . "; name=\"" . basename($input_file) . "\"\n";
$message .= "Content-Disposition: attachment; filename=\"" . basename($input_file) . "\"\n";
$message .= "Content-Transfer-Encoding: base64\n";
$message .= "\n";
$message .= chunk_split(base64_encode(file_get_contents($input_file)))."\n";

$message .= "--" . $boundary . "--";

mb_send_mail(ADMIN_MAIL, "Test mail", $message, $additional_headers);

echo ADMIN_MAIL;
?>
