
<?php

    session_abort();

    $_SESSION['login_entregador'] = false;

    header("Location: LoginEntregador.php");

?>