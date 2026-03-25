CREATE DATABASE netflix;
USE netflix;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    celular VARCHAR(20),
    nascimento DATE,
    plano VARCHAR(50),
    senha VARCHAR(255) NOT NULL
);