CREATE TRIGGER trigger_actualizar_utilizador
BEFORE UPDATE ON utilizadores
FOR EACH ROW
BEGIN
    UPDATE utilizadores SET actualizado_em = CURRENT_TIMESTAMP WHERE id = OLD.id;
END;

CREATE TRIGGER trigger_actualizar_produto
BEFORE UPDATE ON produtos
FOR EACH ROW
BEGIN
    UPDATE produtos SET actualizado_em = CURRENT_TIMESTAMP WHERE id = OLD.id;
END;

CREATE TRIGGER trigger_actualizar_categoria
BEFORE UPDATE ON categorias
FOR EACH ROW
BEGIN
    UPDATE categorias SET actualizado_em = CURRENT_TIMESTAMP WHERE id = OLD.id;
END;

CREATE TRIGGER trigger_actualizar_imagem
AFTER UPDATE ON imagens_produto
FOR EACH ROW
BEGIN
    UPDATE imagens_produto SET actualizado_em = CURRENT_TIMESTAMP WHERE id = OLD.id;
END;

CREATE TRIGGER trigger_actualizar_encomendas
AFTER UPDATE ON encomendas
FOR EACH ROW
BEGIN
    UPDATE encomendas SET actualizado_em = CURRENT_TIMESTAMP WHERE id = OLD.id;
END;
