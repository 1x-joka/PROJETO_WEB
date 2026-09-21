# Projeto WEB

> Repositório para administrar os estudos de Programação Web III 
> Escola Técnica Estadual Ilza Nascimento Pintus — São José dos Campos, 2026

---

## Sobre o Projeto

Este projeto consiste no desenvolvimento de uma aplicação web interativa desenvolvida no âmbito da disciplina de **Programação Web III** do curso Técnico em Desenvolvimento de Sistemas. 

O CRUD Mundo tem como objetivo gerenciar dados sobre países, continentes, cidades e governantes, permitindo a manutenção completa das informações e a gestão de acesso de usuários com autenticação e redefinição de senhas.

---

## Funcionalidades

- **Autenticação de Usuários:** Tela de login e controle de sessão (`login.php`).
- **Gerenciamento de Acesso:** Manutenção e alteração de senhas (`manutencao_senha.php`, `trocar_senha.php`).
- **Gestão Geográfica (CRUD):**
  - Cadastro e consulta de **Continentes** (`continente.php`).
  - Cadastro e consulta de **Países** (`pais.php`).
  - Cadastro e consulta de **Cidades** (`cidade.php`)
  - Cadastro e consulta de **Governantes** (`governante.php`)
- **Interface e Estilização:** Layout responsivo centralizado com folha de estilos (`style.css`) e scripts interativos em JavaScript (`script.js`)

---

## Tecnologias Utilizadas

| Camada | Tecnologia |
|--------|-----------|
| Front-end | HTML, CSS, JavaScript |
| Back-end | PHP |
| Banco de Dados | MySQL |
| Controle de Versão | Git e GitHub |

---

## Como Executar

### Pré-requisitos

- [PHP](https://www.php.org/) v8.0 ou superior
- [MySQL](https://www.mysql.com/) v8 ou superior
- [Git](https://git-scm.com/)

## Estrutura do Projeto

Organização do diretório e arquivos do repositório:

```text
crud-mundo/
├── .gitattributes       # Configurações de atributos do Git
├── LICENSE              # Licença do repositório
├── README.md            # Documentação principal do repositório
├── cidade.php           # Gestão e listagem de cidades
├── codigo.sql           # Script de criação e população do banco de dados MySQL
├── continente.php       # Gestão e listagem de continentes
├── governante.php       # Gestão e listagem de governantes
├── index.html           # Página inicial / estrutura base de apresentação
├── index.php            # Dashboard / página principal em PHP
├── login.php            # Tela de autenticação e login de usuários
├── manutencao_senha.php # Painel de recuperação/manutenção de senhas
├── pais.php             # Gestão e listagem de países
├── script.js            # Comportamentos interativos no Front-end
├── style.css            # Estilização visual da aplicação
└── trocar_senha.php     # Formulário para troca de senha
```

---

Desenvolvido por Joaquim Pereira Lima — São José dos Campos, 2026
