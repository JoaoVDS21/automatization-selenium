DROP DATABASE IF EXISTS atividade3_qts;
CREATE DATABASE atividade3_qts;
USE atividade3_qts;
CREATE TABLE cliente(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(60),
    sobrenome VARCHAR(60),
    email VARCHAR(250),
    cidade VARCHAR(200),
    empresaatual VARCHAR(200)        
)engine=InnoDB;
