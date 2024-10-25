INSERT INTO utilizadores (nome, email, password, distrito, concelho, admin) VALUES
('João Silva', 'joao.silva@example.com', 'password123', 'Lisboa', 'Lisboa', 1),
('Maria Costa', 'maria.costa@example.com', 'senha123', 'Setúbal', 'Setúbal', 0),
('Pedro Gonçalves', 'pedro.goncalves@example.com', 'palavra_passe', 'Porto', 'Vila Nova de Gaia', 0),
('Ana Matos', 'ana.matos@example.com', 'segura123', 'Faro', 'Faro', 0),
('Rita Mendes', 'rita.mendes@example.com', 'senha_segura', 'Lisboa', 'Cascais', 0),
('Carlos Sousa', 'carlos.sousa@example.com', 'segura_pass', 'Setúbal', 'Sesimbra', 0),
('Sofia Lopes', 'sofia.lopes@example.com', 'minha_senha', 'Porto', 'Matosinhos', 0),
('Tiago Faria', 'tiago.faria@example.com', 'password987', 'Lisboa', 'Sintra', 0),
('Helena Alves', 'helena.alves@example.com', '123senha', 'Coimbra', 'Coimbra', 0),
('Miguel Nunes', 'miguel.nunes@example.com', 'senha1234', 'Leiria', 'Leiria', 0);

INSERT INTO categorias (nome) VALUES
('Tecnologia'),
('Livros'),
('Moda'),
('Casa e Jardim'),
('Brinquedos'),
('Desporto'),
('Alimentação'),
('Beleza e Saúde'),
('Automóveis'),
('Eletrónica');

INSERT INTO produtos (titulo, descricao, preco, categoria_id) VALUES
('Smartphone XYZ', 'Smartphone de última geração com 128GB', 499.99, 1),
('Livro de Programação', 'Livro sobre Laravel e PHP', 29.99, 2),
('T-shirt Branca', 'T-shirt básica de algodão', 9.99, 3),
('Conjunto de Facas', 'Conjunto de 6 facas de cozinha', 49.99, 4),
('Carrinho de Brinquedo', 'Carrinho de brinquedo de metal', 14.99, 5),
('Bicicleta de Montanha', 'Bicicleta de montanha para adultos', 299.99, 6),
('Cesta de Frutas', 'Cesta com várias frutas frescas', 24.99, 7),
('Creme Hidratante', 'Creme hidratante para pele seca', 19.99, 8),
('Pneu para Carro', 'Pneu para automóveis de tamanho médio', 89.99, 9),
('Portátil ABC', 'Computador portátil com 16GB de RAM', 999.99, 10);

INSERT INTO imagens_produtos (produto_id, URL_imagem) VALUES
(1, 'imagens/smartphone1.jpg'),
(1, 'imagens/smartphone2.jpg'),
(2, 'imagens/livro1.jpg'),
(3, 'imagens/tshirt1.jpg'),
(4, 'imagens/facas1.jpg'),
(5, 'imagens/carrinho1.jpg'),
(6, 'imagens/bicicleta1.jpg'),
(7, 'imagens/frutas1.jpg'),
(8, 'imagens/creme1.jpg'),
(9, 'imagens/pneu1.jpg'),
(10, 'imagens/portatil1.jpg');

INSERT INTO encomendas (utilizador_id, produto_id, quantidade, criado_em, actualizado_em) VALUES
(1, 3, 2, '2024-10-01 10:15:00', '2024-10-01 10:15:00'),
(3, 1, 5, '2024-10-02 12:30:00', '2024-10-02 12:30:00'),
(9, 2, 1, '2024-10-03 09:45:00', '2024-10-03 09:45:00'),
(1, 4, 3, '2024-10-04 14:20:00', '2024-10-04 14:20:00'),
(9, 2, 4, '2024-10-05 11:00:00', '2024-10-05 11:00:00'),
(9, 3, 2, '2024-10-06 15:35:00', '2024-10-06 15:35:00'),
(3, 1, 6, '2024-10-07 08:10:00', '2024-10-07 08:10:00');
