<?php
session_start();
unset($_SESSION);
session_destroy();
header("location:index.php?logout=1");
exit;
?>