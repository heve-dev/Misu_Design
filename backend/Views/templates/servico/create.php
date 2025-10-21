<div class="w3-container">
    <h3>Sou o create Servico</h3>
 o action é pra onde o form vai ser enviado 
<form action="/backend/servico/salvar" method="POST" enctype="multipart/form-data" class="w3-container w3-card-4">
    <!-- NOME -->
    <label class="w3-text-blue" for="Nome">Nome do Serviço</label>
    <input class="w3-input w3-border" type="text" name="nome_servico" required>
    <br>
        <!-- DESCRIÇÃO -->
    <label class="w3-text-blue" for="Descrição">Descrição do Serviço</label>
    <input  class="w3-input w3-border" type="text" name="descricao_servico" required>
    <br>
        <!-- FOTO -->
    <label class="w3-text-blue" for="Foto">Foto do Serviço</label>
    <input class="w3-input w3-border" type="file" name="foto_servico" required>
    <br>
        <!-- PRODUTO -->
    <div class="mb-3">
        <label class="w3-text-blue">Produtos</label>
        <div id="produtos-container"></div>
        <button type="button" onclick="addProduto()" class="w3-button w3-teal">Adicionar Produto</button>
    </div>
        <!-- CATEGORIA -->
     <label class="w3-text-blue" for="Categoria">Categoria do Serviço</label>
    <select name="categoria_servico" id="categoria_servico" required>
        <?php 
        foreach($categorias as $categoria){
            echo '<option value='.$categoria["categoria_servico"].'>'.$categoria["categoria_servico"].'</option>';
        }
        ?>
    </select>
        <!-- SALVAR -->
         
            <button class="w3-button w3-blue" type="submit">Salvar Serviço</button>
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
</div>
