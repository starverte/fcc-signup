<?php
session_start();
session_destroy();
header('Location: '.($_REQUEST['goto']?:'http://fortcollinscreative.com/'));
exit();
