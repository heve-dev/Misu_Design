<div>Sou o index</div>
<php foreach($categoria): ?>
    <p><?= $categoria['id_categoria'] ?></p>
    <p><?= $categoria['nome_categoria'] ?></p>
    <p><?= $categoria['tipo_categoria'] ?></p>
    <p><?= $categoria['status_categoria'] ?></p>

    <php endforeach; ?>