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
    <div class="mb-3">
        <label class="w3-text-blue">Produtos</label>
        <div id="produtos-container"></div>
        <button type="button" onclick="addProduto()" class="w3-button w3-teal">Adicionar Produto</button>
    </div>
     <label for="Categoria">Categoria</label>
    <select name="categoria_servico" id="categoria_servico" required>
        <?php 
        foreach($categorias as $categoria){
            echo '<option value='.$categoria["categoria_servico"].'>'.$categoria["categoria_servico"].'</option>';
        }
        ?>
    </select>
    <button type="submit">Salvar</button>

</form>

<script>
let produtoCount = 0;
function addProduto() {
        produtoCount++;
        const produtoDiv = document.createElement('div');
        produtoDiv.setAttribute('id', `produto-${produtoCount}`);
        produtoDiv.classList.add('mb-3');
        produtoDiv.innerHTML = `
            <p>produto ${produtoCount} <button type="button" onclick="removeproduto(${produtoCount})" class="w3-button w3-red">Remover produto</button></p>
            <div id="carrinho-container-${produtoCount}">
                <div class="mb-3">
                    <label class="w3-text-blue">Produto</label>
                    <input type="text" name="carrinho[${produtoCount}][]" placeholder="Nome do produto ${produtoCount}" class="w3-input w3-border" required>
                </div>
                <div class="mb-3">
                    <label class="w3-text-blue">Quantidade</label>
                    <input type="text" name="quantidade" placeholder="Quantidade do produto ${produtoCount}" class="w3-input w3-border" required>
                </div>
            </div>
        `;
        document.getElementById('produtos-container').appendChild(produtoDiv);
    }
    function removeproduto(semestreId) {
        const semestreDiv = document.getElementById(`produto-${semestreId}`);
        semestreDiv.remove();
    }
</script>