<?php
    $chave = 'ChavedeSegurança';
    $hash = hash('sha256', $chave . date('Y-m-d'));
?>