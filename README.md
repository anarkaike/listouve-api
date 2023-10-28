
<center>Desenvolvido com</center>
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Gestão de Filas de Eventos

### Para iniciar o projeto, siga os seguintes passos:
<b>Passo 1:</b>   
Crie uma base de dados vazia.   



<b>Passo 2:</b>    
Copie o arquivo .env.example na raiz do projeto atualizando com as credenciais de banco de dados.


<b>Passo 3:</b>    
Instale as bibliotecas componser com o seguinte comando:
```
composer install
```

<b>Passo 4:</b>    
Execute as migrations para gerar o banco de dados:
```
php artisan migrate 
```

Laravel é um framework de aplicação web com uma sintaxe expressiva e elegante. Acreditamos que o desenvolvimento deve ser uma experiência agradável e criativa para ser verdadeiramente gratificante. Laravel facilita o desenvolvimento, tornando mais simples tarefas comuns utilizadas em muitos projetos web, como:

O Laravel é acessível, poderoso e fornece as ferramentas necessárias para aplicativos grandes e robustos.

Para aprender mais ou consultar alguma função específica, consulte a documentação oficial no seguinte link:   
https://laravel.com/docs/10.x

## Sobre o Sistema
ListouVe é um sistema para gerenciamento de listas de eventos contruído para funcionar como um SaaS.

## Diagrama Entidade Relacional
### Entidades:
- Usuários (<b>Tabela</b>: users)   
Essa é a tabela criada pelo Laravel Sanctum, para geração de tokens usados para iteragir com a API.


- Eventos (<b>Tabela</b>: events)   
Armazena os dados sobre o evento propriamente dito. As listas serão criadas a partir de um evento.



- Listas de Eventos (<b>Tabela</b>: events_lists)   
Armazera os dados sobre a lista que será usada na entrada do evento.


- Itens de Lista de Evento (<b>Tabela</b>: events_lists_items)   
Armazena dados do da pessoa que se inscreveu na lista do evento.

https://dbdiagram.io/d/Gestao-de-Recepcao-65333593ffbf5169f024e94a

## Padronizações

### Campos de Auditorias
Todas as tabelas (com exceção das mn e tokens) possuem as seguintes colunas de auditoria:   
 - <b>created_at</b>  
Data e hora de criação do registro.


 - <b>created_by</b>   
Usuário que criou o registro.


 - <b>updated_at</b>   
Data e hora da última atualização do registro.


 - <b>updated_by</b>   
Usuário que atualizou o registro por último.


 - <b>updated_values</b>   
Json contendo histórico de atualizações do registro.


 - <b>deleted_at</b>   
Data e hora da exclusão lógica do registro.


 - <b>deleted_by</b>   
Usuário que excluiu o registro.


### Padronizações de Camadas

#### Actions - Regras de Ngócios
Os controllers chamarão os actions, para permitir que regras de negócio sejam aplicadas nesta camada. Exemplos: envio de emails, atualizações secundárias, notificações, criações de logs, geração de histórico de atualizações e etc.

#### Repositories - Consulta de Dados
No repository será onde usaremos Eloquent para iteragir com banco de dados, ou outra fonte de dados.

#### Interfaces
Atualmente temos interfaces para actions, controllers que possuem crud e repositories.

#### Requests - Validação de Payload
Os controllers chamarão os actions, para permitir que regras de negócio sejam aplicadas nesta camada. Exemplos: envio de emails, atualizações secundárias, notificações, criações de logs, geração de histórico de atualizações e etc.

#### Api Customs Responsable - Padronização de Retorno da Api
Resposta Customizada para padronizar respostas na API.    
No projeto até o momento temos dois tipos de retornos:
- <b>SUCESSO:</b>    
  File: App/Http/Responses/ApiSuccessResponse.php   
  Responsável pela padronização dos retornos exitosos.

 
- <b>ERRO:</b>   
  File: App/Http/Responses/ApiErrorResponse.php   
  Responsável pela padronização dos retornos com erro.


## Testes

Para executar os testes rode o seguinte comando a partir da raiz do projeto:
``` 
vendor/bin/phpunit
````

## Documentação da API 
Foi gerada uma documentação usando a ferramenta postman.    


Acesse no link:   
https://documenter.getpostman.com/view/9737921/2s9YRDzVuM

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
