CREATE DATABASE sgb_basico;

use sgb_basico;
CREATE TABLE usuarios(
    id_usuario int AUTO_INCREMENT PRIMARY KEY,
    nome varchar(30);
    telefone varchar(30);
    email varchar(40);
    senha varchar(32);
);

USE sgb_basico;
CREATE TABLE livro(
  id_livro int AUTO_INCREMENT PRIMARY key,
  nome varchar(60),
  ano varchar(5),
  paginas int(4),
  emprestado boolean
);
use sgb_basico;
ALTER TABLE livro ADD COLUMN id_usuario int;

USE sgb_basico;
CREATE TABLE emprestimos(
    id_emprestimo int AUTO_INCREMENT PRIMARY KEY,
    data_emprestimo date NOT NULL,
    dias_emprestimos int(4) NOT NULL,
    id_usuario int(5),
    id_livro int(5),
    FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario),
    FOREIGN KEY (id_livro) REFERENCES livro (id_livro)
);