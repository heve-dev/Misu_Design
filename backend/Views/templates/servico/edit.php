<div>Sou o edit Serviço</div>
 
<form action="/backend/servico/atualizar/<?php echo $servico['id_servico']; ?>" method="post" enctype="multipart/form-data">
    <label for="Nome">Nome</label>
    <input type="text" name="nome_servico" id="nome_servico" value= "<?php echo $servico['nome_servico']; ?>" required>
    <br>
    <label for="Email">Email</label>
    <input type="email" name="email_servico" id="email_servico" value= "<?php echo $servico['email_servico']; ?>" required>
    <br>
    <label for="Senha">Senha</label>
    <input type="password" name="senha_servico" id="senha_servico" value= "" required>
    <br>
    <label for="Tipo">Tipo</label>
    <select name="tipo_servico" id="tipo_servico" value= "<?php echo $servico['tipo_servico']; ?>" required>
        <option value="admin">Admin</option>
        <option value="user">Usuário</option>
<select>
    <br>
    <label for="imagem">Imagem</label>
    <input type="file" name="imagem" id="imagem" accept="image/*">

    <button type="submit">Salvar</button>
</form>