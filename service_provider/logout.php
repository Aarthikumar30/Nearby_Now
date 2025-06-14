<?php
session_name('nearby');
session_start();
session_destroy();
header("Location: index.php");
exit();
?>
