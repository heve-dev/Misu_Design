<div>Sou o create Servico</div>
 o action é pra onde o form vai ser enviado 
<form action="/backend/servico/salvar" method="post" enctype="multipart/form-data">
    <label for="Nome">Nome</label>
    <input type="text" name="nome_servico" id="nome_servico" required>
    <br>

    
    <label for="Email">Email</label>
    <input type="email" name="email_usuario" id="email_usuario" required>
    <br>
    <label for="Senha">Senha</label>
    <input type="password" name="senha_usuario" id="senha_usuario" required>
    <br>
    <label for="Categoria">Categoria</label>
    <select name="categoria_servico" id="categoria_servico" required>
        <?php 
        foreach($categorias as $categoria){
            echo '<option value='.$categoria["id_categoria"].'>'.$categoria["nome_categoria"].'</option>';
        }
        ?>
    </select>
    <button type="submit">Salvar</button>

</form>