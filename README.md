# Guia de Instalação do Projeto
### Pré-requisitos
Antes de começar, certifique-se de ter as seguintes dependências instaladas em seu ambiente de desenvolvimento:

- PHP (8.2.6)
- Composer (2.5.8)
- Node.js (18.16.0)
- Laravel CLI instalado globalmente. Se você ainda não possui o Laravel CLI instalado, pode instalá-lo executando o seguinte comando no terminal:

```
composer global require laravel/installer
```

### Passo 1: Clonar o repositório do GitHub
Comece clonando o repositório do seu projeto do GitHub para o seu ambiente de desenvolvimento. Abra o terminal e execute o seguinte comando:

```
git clone https://github.com/otaldopira/medocup-web
```

Após a conclusão do comando, navegue até o diretório do projeto:
```
cd medocup-web
```
### Passo 2: Instalar as dependências do Laravel
No diretório do projeto, instale as dependências do Laravel executando o seguinte comando no terminal:
```
composer install
```
### Passo 3: Instalar as dependências do Vue.js e Inertia.js
Agora, instale as dependências do Vue.js e Inertia.js usando o npm. Execute o seguinte comando no terminal:
```
npm install
```
### Passo 4: Configurar o arquivo .env
Faça uma cópia do arquivo .env.example e renomeie-a para .env. Abra o arquivo .env no seu editor de código e atualize as configurações de banco de dados de acordo com o seu ambiente.

### Passo 5: Compilar os assets
Agora, compile os assets do Vue.js e Inertia.js executando o seguinte comando no terminal:
```
npm run dev
```
### Passo 6: Executar o servidor de desenvolvimento
Inicie o servidor de desenvolvimento do Laravel executando o seguinte comando no terminal:
```
php artisan serve
```
Após a execução do comando, você poderá acessar o projeto em http://localhost:8000.
