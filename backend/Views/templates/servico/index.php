<div>Sou o index</div>
<php foreach($servicos as $servico): ?>
    <p><?= $servico['id_servico'] ?></p>
    <p><?= $servico['nome_servico'] ?></p>
    <p><?= $servico['tipo_servico'] ?></p>
    <p><?= $servico['status_servico'] ?></p>

    <php endforeach; ?>