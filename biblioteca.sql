CREATE DATABASE Biblioteca;
USE Biblioteca;
CREATE TABLE Clientes 
( 
 CPF INT PRIMARY KEY,  
 Nome VARCHAR(50) NOT NULL,  
 Email VARCHAR(50),  
 UNIQUE (Email)
); 

CREATE TABLE Livros 
( 
 ISBN INT PRIMARY KEY,  
 Titulo VARCHAR(50) NOT NULL,  
 id_autor INT,	
 UNIQUE (Titulo)
); 

CREATE TABLE Autores 
( 
 id_autor INT PRIMARY KEY auto_increment,  
 Nome INT
); 

CREATE TABLE Itens 
( 
id_item int primary key auto_increment,
 CPF INT,  
 ISBN INT,  
 Quant_item INT NOT NULL 
); 

CREATE TABLE Estoque 
( 
 id_estoque INT PRIMARY KEY auto_increment,
 ISBN INT,  
 id_autor INT,  
 Quant_estoque INT NOT NULL
); 

ALTER TABLE Itens ADD FOREIGN KEY(CPF) REFERENCES Clientes (CPF);
ALTER TABLE Itens ADD FOREIGN KEY(ISBN) REFERENCES Livros (ISBN);
ALTER TABLE livros ADD FOREIGN KEY(id_autor) REFERENCES autores (id_autor);
ALTER TABLE Estoque ADD FOREIGN KEY(ISBN) REFERENCES Livros (ISBN);
ALTER TABLE Estoque ADD FOREIGN KEY(id_autor) REFERENCES Autores (id_autor)