

<?php

    session_abort();

    $_SESSION['login_adm'] = false;

    header("Location: index.php");


?>