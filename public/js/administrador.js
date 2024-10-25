// Obter o token CSRF da meta tag
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Utilizadores
// Função para abrir o modal e preencher com os dados do utilizador
function showEditUserModal(id) {
    // Pega os valores do utilizador selecionado na tabela
    let nome = document.querySelector(`#utilizador-${id} td:nth-child(1)`).textContent;
    let email = document.querySelector(`#utilizador-${id} td:nth-child(2)`).textContent;
    let distrito = document.querySelector(`#utilizador-${id} td:nth-child(3)`).textContent;
    let concelho = document.querySelector(`#utilizador-${id} td:nth-child(4)`).textContent;
    let admin = document.querySelector(`#utilizador-${id} td:nth-child(5)`).textContent === 'Sim';

    // Preenche o modal com os dados do utilizador
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-nome').value = nome;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-distrito').value = distrito;
    document.getElementById('edit-concelho').value = concelho;
    document.getElementById('edit-admin').checked = admin;

    // Mostrar o modal
    var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
    editUserModal.show();
}

// Submeter o formulário de edição via AJAX
document.getElementById('editUserForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir comportamento padrão

    let id = document.getElementById('edit-id').value;
    let nome = document.getElementById('edit-nome').value;
    let email = document.getElementById('edit-email').value;
    let distrito = document.getElementById('edit-distrito').value;
    let concelho = document.getElementById('edit-concelho').value;
    let admin = document.getElementById('edit-admin').checked ? 1 : 0;

    // Obter o token CSRF da pagina principal (layout.blade.php)
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Enviar os dados via AJAX para o servidor
    fetch(`/administrador/utilizadores/${id}/update`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            nome: nome,
            email: email,
            distrito: distrito,
            concelho: concelho,
            admin: admin
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao processar a requisição.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Fechar o modal
            var editUserModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            editUserModal.hide();
            // Converte a string da data para um objeto Date
            let date = new Date(data.utilizador.actualizado_em);

            // Formata a data para "YYYY-MM-DD HH:MM:SS", formato português
            let formattedDate = date.toLocaleString('pt-PT', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });

            // Atualizar a tabela com os novos dados
            document.querySelector(`#utilizador-${id} td:nth-child(1)`).textContent = nome;
            document.querySelector(`#utilizador-${id} td:nth-child(2)`).textContent = email;
            document.querySelector(`#utilizador-${id} td:nth-child(3)`).textContent = distrito;
            document.querySelector(`#utilizador-${id} td:nth-child(4)`).textContent = concelho;
            document.querySelector(`#utilizador-${id} td:nth-child(5)`).textContent = admin ? 'Sim' : 'Não';
            document.querySelector(`#utilizador-${id} td:nth-child(8)`).textContent = formattedDate;

        } else {
            alert('Erro ao atualizar o utilizador.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
    });
});

// Função para abrir o modal de criação de utilizador
function showCreateUserModal() {
    // Limpa os campos do modal
    document.getElementById('create-nome').value = '';
    document.getElementById('create-email').value = '';
    document.getElementById('create-distrito').value = '';
    document.getElementById('create-concelho').value = '';
    document.getElementById('create-admin').checked = false;

    // Mostrar o modal de criação
    var createUserModal = new bootstrap.Modal(document.getElementById('createUserModal'));
    createUserModal.show();
}

// Função para submeter o formulário de criação de utilizador via AJAX
document.getElementById('createUserForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir comportamento padrão do formulário

    let nome = document.getElementById('create-nome').value;
    let email = document.getElementById('create-email').value;
    let password = document.getElementById('create-password').value
    let distrito = document.getElementById('create-distrito').value;
    let concelho = document.getElementById('create-concelho').value;
    let admin = document.getElementById('create-admin').checked ? 1 : 0;

    // Obter o token CSRF da meta tag
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Enviar os dados via AJAX para o servidor
    fetch('/administrador/utilizadores/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            nome: nome,
            email: email,
            password: password,
            distrito: distrito,
            concelho: concelho,
            admin: admin
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao processar a requisição.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Fechar o modal de criação
            var createUserModal = bootstrap.Modal.getInstance(document.getElementById('createUserModal'));
            createUserModal.hide();

            function formatarData(dataStr) {
                let data = new Date(dataStr);
                let dia = ('0' + data.getDate()).slice(-2);
                let mes = ('0' + (data.getMonth() + 1)).slice(-2);
                let ano = data.getFullYear();
                let horas = ('0' + data.getHours()).slice(-2);
                let minutos = ('0' + data.getMinutes()).slice(-2);
                let segundos = ('0' + data.getSeconds()).slice(-2);

                return `${dia}/${mes}/${ano}, ${horas}:${minutos}:${segundos}`;
            }

            // Adicionar o novo utilizador na tabela (atualizar dinamicamente)
            let newRow = `
                <tr id="utilizador-${data.utilizador.id}">
                    <td>${data.utilizador.nome}</td>
                    <td>${data.utilizador.email}</td>
                    <td>${data.utilizador.distrito}</td>
                    <td>${data.utilizador.concelho}</td>
                    <td>${data.utilizador.admin ? 'Sim' : 'Não'}</td>
                    <td>${data.utilizador.ultimo_login ? formatarData(data.utilizador.ultimo_login) : 'N/A'}</td>
                    <td>${formatarData(data.utilizador.criado_em)}</td>
                    <td>${formatarData(data.utilizador.actualizado_em)}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="showEditUserModal(${data.utilizador.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${data.utilizador.id})">Apagar</button>
                    </td>
                </tr>
            `;

            document.querySelector('#tabela-utilizadores tbody').insertAdjacentHTML('beforeend', newRow);

        } else {
            alert('Erro ao criar o utilizador.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao criar o utilizador.');
    });
});

// Função para apagar utilizador
function deleteUser(id) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (confirm('Tem a certeza que deseja apagar este utilizador?')) {
        fetch(`/administrador/utilizadores/${id}/destroy`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao apagar utilizador.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remover a linha da tabela
                document.getElementById(`utilizador-${id}`).remove();
            } else {
                alert('Erro ao apagar o utilizador.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    }
}

// Função para abrir o modal de criação de categoria
function showCreateCategoryModal() {
    document.getElementById('create-category-name').value = '';
    var createCategoryModal = new bootstrap.Modal(document.getElementById('createCategoryModal'));
    createCategoryModal.show();
}

// Categorias
// Submeter o formulário de criação de categoria via AJAX
document.getElementById('createCategoryForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let nome = document.getElementById('create-category-name').value;

    fetch('/administrador/categorias/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            nome: nome
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao processar a requisição.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            var createCategoryModal = bootstrap.Modal.getInstance(document.getElementById('createCategoryModal'));
            createCategoryModal.hide();
            window.location.reload();

            // let newRow = `
            //     <tr id="categoria-${data.categoria.id}">
            //         <td>${data.categoria.nome}</td>
            //         <td>${data.categoria.criado_em}</td>
            //         <td>${data.categoria.actualizado_em}</td>
            //         <td>
            //             <button class="btn btn-sm btn-warning" onclick="showEditCategoryModal(${data.categoria.id})">Editar</button>
            //             <button class="btn btn-sm btn-danger" onclick="deleteCategory(${data.categoria.id})">Apagar</button>
            //         </td>
            //     </tr>
            // `;
            // document.querySelector('#tabela-categorias tbody').insertAdjacentHTML('beforeend', newRow);

        } else {
            alert('Erro ao criar a categoria.');
        }
    })
    .catch(error => {
        alert('Erro ao criar a categoria.');
    });
});

// Função para abrir o modal de edição de categoria
function showEditCategoryModal(id) {
    let nome = document.querySelector(`#categoria-${id} td:nth-child(1)`).textContent;

    document.getElementById('edit-category-id').value = id;
    document.getElementById('edit-category-name').value = nome;

    var editCategoryModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
    editCategoryModal.show();
}

// Submeter o formulário de edição de categoria via AJAX
document.getElementById('editCategoryForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let id = document.getElementById('edit-category-id').value;
    let nome = document.getElementById('edit-category-name').value;

    fetch(`/administrador/categorias/${id}/update`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            nome: nome
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao processar a requisição.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            var editCategoryModal = bootstrap.Modal.getInstance(document.getElementById('editCategoryModal'));
            editCategoryModal.hide();

            document.querySelector(`#categoria-${id} td:nth-child(1)`).textContent = nome;
            document.querySelector(`#categoria-${id} td:nth-child(3)`).textContent = new Date().toLocaleString('pt-PT', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });

        } else {
            alert('Erro ao atualizar a categoria.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao atualizar a categoria.');
    });
});

// Função para apagar uma categoria
function deleteCategory(id) {
    if (confirm('Tem a certeza que deseja apagar esta categoria?')) {
        fetch(`/administrador/categorias/${id}/destroy`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao apagar a categoria.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById(`categoria-${id}`).remove();
            } else {
                alert('Erro ao apagar a categoria.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao apagar a categoria.');
        });
    }
}

// Produtos
// Submeter o formulário de criação de produto via AJAX
document.getElementById('createProdutoForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir comportamento padrão do formulário

    let formData = new FormData();
    formData.append('titulo', document.getElementById('create-titulo').value);
    formData.append('descricao', document.getElementById('create-descricao').value);
    formData.append('preco', document.getElementById('create-preco').value);
    formData.append('categoria_id', document.getElementById('create-categoria').value);

    // Adicionar imagem ao FormData
    let imagemInput = document.getElementById('create-imagem');
    if (imagemInput.files.length > 0) {
        formData.append('imagem', imagemInput.files[0]); // Apenas uma imagem
    }

    // Enviar os dados via AJAX para o servidor
    fetch('/administrador/produtos/store', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token // Adicionar CSRF Token no cabeçalho
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao processar a requisição.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Fechar o modal de criação
            var createProdutoModal = bootstrap.Modal.getInstance(document.getElementById('createProdutoModal'));
            createProdutoModal.hide();

            window.location.reload();
        } else {
            alert('Erro ao criar o produto.');
        }
    })
    .catch(error => console.error('Erro ao criar produto:', error));
});

// Função para abrir o modal de edição de produto com os dados preenchidos corretamente
function showEditProdutoModal(id) {
    // Pega os valores do produto selecionado na tabela
    let titulo = document.querySelector(`#produto-${id} td:nth-child(1)`).textContent;
    let descricao = document.querySelector(`#produto-${id} td:nth-child(2)`).textContent;
    let preco = document.querySelector(`#produto-${id} td:nth-child(3)`).textContent.trim().replace('€', ''); // Remover o símbolo €
    let categoriaId = document.querySelector(`#produto-${id} td:nth-child(4)`).dataset.categoriaId;

    // Preenche o modal com os dados do produto
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-titulo').value = titulo;
    document.getElementById('edit-descricao').value = descricao;
    document.getElementById('edit-preco').value = preco;
    document.getElementById('edit-categoria').value = categoriaId;

    // Mostrar o modal
    var editProdutoModal = new bootstrap.Modal(document.getElementById('editProdutoModal'));
    editProdutoModal.show();
}

// Função para submeter a edição do produto via AJAX
document.getElementById('editProdutoForm').addEventListener('submit', function(event) {
    event.preventDefault();

    let id = document.getElementById('edit-id').value;

    let formData = new FormData();
    formData.append('_method', 'PUT');
    formData.append('titulo', document.getElementById('edit-titulo').value);
    formData.append('descricao', document.getElementById('edit-descricao').value);
    formData.append('preco', document.getElementById('edit-preco').value);
    formData.append('categoria_id', document.getElementById('edit-categoria').value);

    // Adicionar nova imagem, se estiver presente
    let imagemInput = document.getElementById('edit-imagem');
    if (imagemInput.files.length > 0) {
        formData.append('imagem', imagemInput.files[0]);
    }

    // Enviar os dados via AJAX para o servidor
    fetch(`/administrador/produtos/${id}/update`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token // Adicionar CSRF Token no cabeçalho
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao editar produto.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const editProdutoModal = bootstrap.Modal.getInstance(document.getElementById('editProdutoModal'));
            editProdutoModal.hide();

            window.location.reload();

        }
    })
    .catch(error => console.error('Erro ao editar produto:', error));
});

// Função para abrir o modal de criação de produto
function showCreateProdutoModal() {
    document.getElementById('create-titulo').value = '';
    document.getElementById('create-descricao').value = '';
    document.getElementById('create-preco').value = '';
    document.getElementById('create-categoria').value = '';
    document.getElementById('create-imagem').value = ''; // Limpar imagens

    var createProdutoModal = new bootstrap.Modal(document.getElementById('createProdutoModal'));
    createProdutoModal.show();
}

// Função para apagar produto
function deleteProduto(id) {
    if (confirm('Tem a certeza que deseja apagar este produto?')) {
        fetch(`/administrador/produtos/${id}/destroy`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao apagar o produto.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.getElementById(`produto-${id}`).remove();
            } else {
                alert('Erro ao apagar o produto.');
            }
        })
        .catch(error => console.error('Erro:', error));
    }
}
