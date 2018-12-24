
# SISAB - Trabalho 3 / 3 
#### Sistema Integrado Simulador de Agência Bancária

Disciplina: Linguagem de Programação e Algoritmos II    
Docente: Prof. MSc. Giovane Sousa      
Discentes: Ivanicio Junior, Ítallo Giullian e Luís Henrique

### Descrição

SISAB - Sistema Integrado Simulador de Agência Bancária. Trabalho Final da disciplina de Algoritmos II, aplicado à metodologia de Programação Orientada a Objetos, onde simula uma Agência Bancária utilizando o modelo MVC. (linguagem definida mediante sorteio) 


A ideia é, basicamente, utilizar todos os conceitos de Orientação a Objetos em um projeto (pseudo) real. 

### Informações
  - Prazo de entrega e apresentação: 06/12/2018;
  - Equipe: Ivanicio Junior, Ítallo Giullian e Luís Henrique;

### Instalação
  1. Clonar o repositório para o diretório de um servidor PHP/MYSQL da sua máquina
      - ``` git clone git@github.com:jsiilva1/sisab.git ```
  
  2. Baixar e instalar o gerenciador de pacotes Composer encontrado em https://getcomposer.org/download/
  
  3. No diretório raiz do projeto, baixar as dependências do Composer   
      - ``` composer require ```
    
  4. Configurar o Banco de Dados   
  
      4.1 Alterar os dados de login do seu Servidor de Banco de Dados local, encontrado em ``` \Config\Database.php ```     
      4.2 Importar o arquivo SQL que está na raiz do projeto para o Servidor de Banco de Dados
