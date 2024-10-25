document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const produtoId = this.getAttribute('data-id');

        fetch('/carrinho/adicionar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ produto_id: produtoId, quantidade: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Produto adicionado ao carrinho!');
                // Atualiza o total de itens no carrinho na navbar
                document.querySelector('.badge').textContent = data.totalItensCarrinho;
            } else {
                alert(data.message || 'Erro ao adicionar o produto ao carrinho.');
            }
        })
        .catch(error => console.error('Erro:', error));
    });
});
