<?php
	require_once '../core/core.init';
	$_SESSION['arterepo'] = 0;
    unset($_SESSION['arterepo']);
    session_destroy();
    header('Location: /arterepo/index.php');
?>