<?php

$nome = 'Hevellin';
$sobrenome = 'Santos';
$profissao = 'programador';
$empresa = "empresa x";
$texto = "abcdefghijklmnopqrstuvwxyz, isso msm";
// echo $nome." ".$sobrenome;
// echo "\n";
// print_r ($nome." ".$sobrenome);
// echo "\n";
$resultado = strtoupper($nome."-".$sobrenome."-".$profissao."-".$empresa);
// deixa tudo minusculo
$resultado = strtolower($nome."-".$sobrenome."-".$profissao."-".$empresa);
// deixa tudo maiusculo
// $resultado = ucfirst($nome." ".$sobrenome." ".$profissao." ".$empresa);
// // deixa a primeira letra maiuscula
// $resultado = ucwords($nome." ".$sobrenome." ".$profissao." ".$empresa);
// deixa a primeira letra de cada palavra maiuscula
$texto = str_replace(",","",$texto);
// remove o que esta no primeiro parametro e substitui pelo segundo parametro
$partes = explode("-",$texto);
$quantidadedepalavras = str_word_count($texto);
$letras = strlen($nome);
var_dump($letras);
 