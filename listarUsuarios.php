<?php
include_once 'backend/Database/Database.php';
include_once 'backend/Model/Usuario.php';

$resultado = buscarUsuarios($db);

// loop - para-for
// for ($i=0; $i < count($resultado); $i++){ 
//     echo $resultado[$i]['nome_usuario'] . "<br>";
// }
//while - usado pra loop infinito( é pra menu ou temporizador) (não é recomendado na maioria das vezes pq se errar pode travar o sistema)
// while (){
//
//}
// foreach - para cada (é o mais usado pra percorrer arrays)



// echo "<h1>Listar Usuários</h1>";
// echo "<ul>";
//  foreach ($resultado as $usuario) {
//      echo "<li>". $usuario['nome_usuario'] ." - ". $usuario['email_usuario'] . "</li>";
//  }
// echo "</ul>";
// var_dump($resultado);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <main>
        <h1>Lista de Usuários</h1>
        <table class="table table-striped">
            <thead>
                <tr> 
                    <th>nome</th>
                    <th>email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($resultado as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['nome_usuario']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email_usuario']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </ul>
    </main>
 
</body>
</html>

