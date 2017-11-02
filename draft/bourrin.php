<?php
$timeout = time()+20;
// while (true) {
// 	fwrite('test.txt', 'w+');
// 	/*if (time() >= $timeout) {
// 		fwrite('test.txt', 'w+');
// 		header('Location: bourrin.php');
// 	}*/
// 	fwrite('test2.txt', 'w+');
// }

$msg = "blablablaDev";
echo strlen($msg).'<hr>';
echo strpos($msg, "Dev").'<hr>';
echo strlen($msg) - strlen("Dev").'<hr>';
echo preg_match("#Dev#", $msg).'<hr>';
echo (strlen($msg) - strlen("Dev")) == strpos($msg, "Dev").'<hr>';
?>