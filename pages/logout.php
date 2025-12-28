<?php
require_once '../config/db.php';
require_once '../config/functions.php';

// Logout user
session_destroy();
set_flash('Anda telah logout.', 'success');
redirect('/ApGuns-Store/index.php');
