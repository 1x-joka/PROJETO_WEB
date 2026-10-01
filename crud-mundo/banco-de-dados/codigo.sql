drop database if exists bd_mundo;
create database bd_mundo;
use bd_mundo;

-- Tabela Continente: Guarda os dados das regiões globais[cite: 12]
create table continente (
	id_continente int auto_increment primary key,
    nome_continente varchar(100) not null unique,
    populacao_continente int not null,
    area_km2_continente decimal(15,2) not null,
    total_paises int default 0 
);

-- Tabela País: Relacionada ao continente[cite: 12]
create table pais (
	id_pais int auto_increment primary key,
    nome_pais varchar(100) not null unique,
    populacao_pais bigint not null, 
    area_km2_pais decimal(15,2) not null,
    idioma_pais varchar(50) not null,
    clima_pais varchar(20) not null,
    regime_politico_pais varchar(50) not null,
    moeda_pais varchar(50) not null,
    id_continente int,
    foreign key (id_continente) references continente(id_continente)
);

-- Tabela Cidade: Relacionada ao país[cite: 12]
create table cidade (
	id_cidade int auto_increment primary key,
    nome_cidade varchar(100) not null,
    populacao_cidade int not null,
    area_km2_cidade decimal(15,2) not null,
    clima_cidade varchar(20) not null,
    data_fundacao date not null,
    id_pais int,
    foreign key (id_pais) references pais(id_pais)
);

-- Tabela Governante: Pode governar um país ou uma cidade[cite: 12]
create table governante (
	id_governante int auto_increment primary key,
    nome_governante varchar(100) not null,
    partido_politico_governante varchar(50) not null,
    data_nascimento_governante date not null,
    idade_governante int not null,
    data_inicio_mandato date not null,
    data_final_mandato date null,
    id_pais int null,
    id_cidade int null,
    foreign key (id_pais) references pais(id_pais),
    foreign key (id_cidade) references cidade(id_cidade)
);

-- Tabela USUARIOS
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL, -- Armazenará o hash da senha
    tentativas_com_erro INT DEFAULT 0,
    bloqueado TINYINT(1) DEFAULT 0,
    primeiro_acesso TINYINT(1) DEFAULT 1
);

-- Tabela LOGS
CREATE TABLE logs (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,
    acao VARCHAR(100) NOT NULL,
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_origem VARCHAR(45) NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

-- Usuário inicial para testes (Login: admin | Senha: 123)
INSERT INTO usuarios (login, senha, primeiro_acesso) 
VALUES ('admin', '$2y$10$wO08sX7wFw9U3hWkK7zH6eN.6o/hG8i719FvUoD5/P7J.z4v4I7.K', 1);