<?php
session_start();

//for alert message
$_SESSION['flash'] = [];
$_SESSION['flash']['success'] = null;
$_SESSION['flash']['error'] = null;