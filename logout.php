<?php
session_start();
session_destroy();

// Set a URL parameter to indicate logout success
header("Location: login.php?logout=true");
exit;
?>
