// Função para abrir o modal e preencher com os dados do utilizador
function showEditModal(id) {
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
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}

// Submeter o formulário de edição via AJAX
document.getElementById('editForm').addEventListener('submit', function(event) {
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
    fetch(`/utilizadores/${id}/editar`, {
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
            var editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            editModal.hide();
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
function showCreateModal() {
    // Limpa os campos do modal
    document.getElementById('create-nome').value = '';
    document.getElementById('create-email').value = '';
    document.getElementById('create-distrito').value = '';
    document.getElementById('create-concelho').value = '';
    document.getElementById('create-admin').checked = false;

    // Mostrar o modal de criação
    var createModal = new bootstrap.Modal(document.getElementById('createModal'));
    createModal.show();
}

// Função para submeter o formulário de criação de utilizador via AJAX
document.getElementById('createForm').addEventListener('submit', function(event) {
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
    fetch('/administrador/create', {
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
            var createModal = bootstrap.Modal.getInstance(document.getElementById('createModal'));
            createModal.hide();

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
                        <button class="btn btn-sm btn-warning" onclick="showEditModal(${data.utilizador.id})">Editar</button>
                    </td>
                </tr>
            `;

            document.querySelector('tbody').insertAdjacentHTML('beforeend', newRow);

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
        fetch(`/administrador/${id}/delete`, {
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
