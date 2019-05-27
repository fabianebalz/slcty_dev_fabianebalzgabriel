<?php
/*Arquivo de conexão de banco de dados
  Fabiane Balz Gabriel - 27/05/2019*/

$dbstring  = "host=192.168.0.2 dbname=wagner user=postgres password=ch3vr0l3t30133";
$conexao  = pg_connect ($dbstring);

//$dbstring = "dbname=wagner user=postgres host=127.0.0.1";
//$conexao  = pg_connect ($dbstring);
?>