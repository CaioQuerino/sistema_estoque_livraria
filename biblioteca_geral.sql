CREATE DATABASE library;

USE library;

-- Criando tabela de autores
CREATE TABLE authors ( 
    id_author INT PRIMARY KEY AUTO_INCREMENT,  
    name_author VARCHAR(50) NOT NULL
); 

-- Criando tabela de filiais
CREATE TABLE branches (
    id_branch BIGINT PRIMARY KEY AUTO_INCREMENT,
    name_branch VARCHAR(50) NOT NULL,
    CEP VARCHAR(9),
    street VARCHAR(100),
    num VARCHAR(100),
    complement VARCHAR(100)
);

-- Criando tabela de livros
CREATE TABLE books ( 
    ISBN VARCHAR(13) PRIMARY KEY,  -- Alterado para VARCHAR(13)
    title VARCHAR(50) NOT NULL,  
    id_author INT NOT NULL,	
    UNIQUE (title),
    price DECIMAL(10,2),  
    quantity_stock INT,
    id_branch BIGINT NOT NULL  
); 

-- Criando tabela de clientes
CREATE TABLE clients ( 
    CPF VARCHAR(14) PRIMARY KEY,  
    name_client VARCHAR(50) NOT NULL,  
    email_client VARCHAR(50),  
    UNIQUE (email_client)
); 

CREATE TABLE stocks (
    id_stock INT PRIMARY KEY AUTO_INCREMENT,
    ISBN VARCHAR(13) NOT NULL,
    id_author INT NOT NULL,
    quantity_stock INT NOT NULL,
    id_branch BIGINT NOT NULL,
    FOREIGN KEY (ISBN) REFERENCES books(ISBN),
    FOREIGN KEY (id_author) REFERENCES authors(id_author),
    FOREIGN KEY (id_branch) REFERENCES branches(id_branch)
);

-- Criando tabela de itens
CREATE TABLE items ( 
    id_item INT PRIMARY KEY AUTO_INCREMENT,
    CPF VARCHAR(14) NOT NULL,  
    ISBN VARCHAR(13) NOT NULL,  
    quantity_item INT NOT NULL,
    id_branch BIGINT NOT NULL  
);

CREATE TABLE cash_flow (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_type ENUM('entrada', 'saida') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL,
    transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Definindo as chaves estrangeiras
ALTER TABLE books ADD FOREIGN KEY (id_author) REFERENCES authors(id_author);
ALTER TABLE books ADD FOREIGN KEY (id_branch) REFERENCES branches(id_branch);
ALTER TABLE items ADD FOREIGN KEY (CPF) REFERENCES clients(CPF);
ALTER TABLE items ADD FOREIGN KEY (ISBN) REFERENCES books(ISBN);
ALTER TABLE items ADD FOREIGN KEY (id_branch) REFERENCES branches(id_branch);

-- Adicionando autores
INSERT INTO authors (name_author) VALUES ('Masashi Kishimoto');
INSERT INTO authors (name_author) VALUES ('Antoine de Saint−Exupery');
INSERT INTO authors (name_author) VALUES ('E. L. James');
INSERT INTO authors (name_author) VALUES ('Márcio M. Rodrigues');
INSERT INTO authors (name_author) VALUES ('Machado de Assis');

-- Adicionando filiais
INSERT INTO branches (name_branch, CEP, street, num, complement) 
VALUES ('Leitura', '21820-005', 'Rua Fonseca', '240', 'Bangu Shopping - 158 A');
INSERT INTO branches (name_branch, CEP, street, num, complement) 
VALUES ('Livraria real engenho', '21710-232', 'Av. de Santa Cruz', '166', 'Loja B');
INSERT INTO branches (name_branch, CEP, street, num, complement) 
VALUES ('Amazon Brasil - GIG1', '25525-000', 'Rua Miguel Nunes', '159', 'Amazon Brasil - GIG1');

-- Adicionando Livros
INSERT INTO books (ISBN, title, id_author, price, quantity_stock, id_branch) 
VALUES ('8542602412', 'Naruto Gold - Vol. 1', '1', '48.00', '50', '1');

INSERT INTO books (ISBN, title, id_author, price, quantity_stock, id_branch) 
VALUES ('8542602609', 'Naruto Gold - Vol. 2 ', '1', '35.90', '50', '1');

INSERT INTO books (ISBN, title, id_author, price, quantity_stock, id_branch) 
VALUES ('8542602625', 'Naruto Gold - Vol. 3', '1', '30.20', '50', '1');

INSERT INTO books (ISBN, title, id_author, price, quantity_stock, id_branch) 
VALUES ('6584956245', 'O Pequeno Príncipe - Edição de Luxo Almofadada', '2', '19.29', '50', '2');

INSERT INTO books (ISBN, title, id_author, price, quantity_stock, id_branch) 
VALUES ('8595081514', 'O Pequeno Príncipe', '2', '40.50', '50', '2');

-- Adicionando clientes
INSERT INTO clients (CPF, name_client, email_client) 
VALUES ('111.111.111-11', 'Caio', 'caioquerino04@gmail.com');
INSERT INTO clients (CPF, name_client, email_client) 
VALUES ('222.222.222-22', 'Fernanda', 'alessandra@gmail.com');
INSERT INTO clients (CPF, name_client, email_client) 
VALUES ('333.333.333-33', 'Gabriela', 'gabriela@gmail.com');
