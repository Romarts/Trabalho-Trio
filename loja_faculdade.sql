-- 1. LIMPEZA INICIAL (Para garantir que não dê erro de "já existe")
DROP DATABASE IF EXISTS loja_faculdade;
CREATE DATABASE loja_faculdade;
USE loja_faculdade;

-- 2. ESTRUTURA DAS TABELAS
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `tipo` enum('admin','cliente') DEFAULT 'cliente',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `estoque` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `data_pedido` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `auditoria_preco` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produto` int(11) DEFAULT NULL,
  `preco_antigo` decimal(10,2) DEFAULT NULL,
  `preco_novo` decimal(10,2) DEFAULT NULL,
  `data_alteracao` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. PROCEDURES E TRIGGERS
DELIMITER $$

-- Procedure de Inserção em Massa
CREATE PROCEDURE `inserir_massa_produtos` ()
BEGIN
    DECLARE i INT DEFAULT 1;
    WHILE i <= 10 DO
        INSERT INTO produtos (nome, descricao, preco, estoque)
        VALUES (CONCAT('Produto ', i), 'Descrição teste', RAND() * 100, 50);
        SET i = i + 1;
    END WHILE;
END$$

-- Trigger de Auditoria
CREATE TRIGGER `trg_auditoria_preco` AFTER UPDATE ON `produtos`
FOR EACH ROW BEGIN
    IF OLD.preco <> NEW.preco THEN
        INSERT INTO auditoria_preco (id_produto, preco_antigo, preco_novo)
        VALUES (OLD.id, OLD.preco, NEW.preco);
    END IF;
END$$

-- Função de Estoque (A Cereja do Bolo)
CREATE FUNCTION verificar_estoque(p_id INT, p_qtd INT) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    DECLARE v_estoque INT;
    SELECT estoque INTO v_estoque FROM produtos WHERE id = p_id;
    
    IF v_estoque >= p_qtd THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END$$

DELIMITER ;


CALL inserir_massa_produtos();

INSERT INTO `usuarios` (`nome`, `email`, `senha`, `tipo`) VALUES
('Socio Admin', 'socio@loja.com', '$2y$10$eImiTXuWVxfM37uY4JANjQ==', 'admin'),
('Cliente Teste', 'cliente@gmail.com', '$2y$10$V6EzUBbI0fzdxz1oWnAwpu8tQS/uxOSEiANB7kvYlGion6zAzdbU.', 'cliente');