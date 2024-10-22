// Obter o token CSRF da meta tag
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Função para abrir o modal de criar nova categoria
function showCreateCategoryModal() {
    var createCategoryModal = new bootstrap.Modal(document.getElementById('createCategoryModal'));
    createCategoryModal.show();
}

// Função para abrir o modal de editar categoria
function showEditCategoryModal(id, nome) {
    document.getElementById('edit-category-id').value = id;
    document.getElementById('edit-nome').value = nome;
    var editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
    editCategoryModal.show();
}

// Função para eliminar uma categoria
function deleteCategory(id) {
    if (confirm('Tem a certeza que deseja eliminar esta categoria?')) {
        // Enviar requisição de DELETE via AJAX
        fetch(`/categorias/${id}/destroy`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao eliminar a categoria.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remover a categoria da página
                document.getElementById(`categoria-${id}`).remove();
            } else {
                alert('Erro ao eliminar a categoria.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    }
}

// Submeter o formulário de criar categoria
document.getElementById('createCategoryForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let nome = document.getElementById('create-nome').value;

    fetch('/categorias/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ nome: nome })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Recarregar a página após sucesso
        } else {
            alert('Erro ao criar categoria.');
        }
    })
    .catch(error => console.error('Erro:', error));
});

// Submeter o formulário de editar categoria
document.getElementById('editCategoryForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let id = document.getElementById('edit-category-id').value;
    let nome = document.getElementById('edit-nome').value;

    fetch(`/categorias/${id}/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ nome: nome })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Recarregar a página após sucesso
        } else {
            alert('Erro ao editar categoria.');
        }
    })
    .catch(error => console.error('Erro:', error));
});
