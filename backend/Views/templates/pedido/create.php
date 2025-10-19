<div>Sou o create Pedido</div>

<form action="/backend/pedido/salvar" method="post" enctype="multipart/form-data">
    <label for="Descricao">Descricao</label>
    <input type="text" name="descricao_pedido" id="descricao_pedido" required>
    <br>

    
    <label for="QuantidadeSolicitada">Quantidade Solicitada</label>
    <input type="decimal" name="quantidade_solicitada" id="quantidade_solicitada" required>
    <br>
    <label for="TotalValor">Total Valor</label>
    <input type="decimal" name="total_valor_pedido" id="total_valor_pedido" required>
    <br>
    <div class="mb-3">
        <label class="w3-text-blue">Produtos</label>
        <div id="produtos-container"></div>
        <button type="button" onclick="addProduto()" class="w3-button w3-teal">Adicionar Produto</button>
    </select>
    <button type="submit">Salvar</button>

</form>