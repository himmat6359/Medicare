<?php
session_start();
session_unset();
session_destroy();

echo   "<script>
        alert('pless login..');
        window.location.href='index.html';
        </script>";
// header('Location: /medion/user_login.html');
exit();
?>
