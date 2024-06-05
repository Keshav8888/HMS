<?php
// Starting the session.
session_start();

// Unsetting the session variables.
session_unset();

// Destroying the session.
session_destroy();

echo "<script>window.location='index.php';</script>";


