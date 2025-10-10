<div>Sou o index</div>
<php foreach($usuarios as $usuario): ?>
    <p><?= $usuario['id_usuario'] ?></p>
    <p><?= $usuario['nome_usuario'] ?></p>
    <p><?= $usuario['email_usuario'] ?></p>
    <p><?= $usuario['tipo_usuario'] ?></p>
    <p><?= $usuario['status_usuario'] ?></p>

    <php endforeach; ?>

    <div class="paginacao-controls" style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
    <div class="page-selector" style="display:flex; align-items:center;">
        <div class="page-nav">
            <?php if ($paginacao['pagina_atual'] > 1): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] - 1 ?>">Anterior</a>
            <?php endif; ?>
            <span style="margin:0 10px;">Página <?= $paginacao['pagina_atual'] ?> de <?= $paginacao['ultima_pagina'] ?></span>
            <?php if ($paginacao['pagina_atual'] < $paginacao['ultima_pagina']): ?>
                <a href="/backend/usuario/listar/<?= $paginacao['pagina_atual'] + 1 ?>">Próximo</a>
            <?php endif; ?>
        </div>
    </div>
</div>