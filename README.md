# Briefing Projeto 5414 - PHP

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Pretende-se a construção de um sistema de gestão de conteúdos, vulgo backend, baseado em PHP/MySQL que permita:

- Autenticação de utilizadores
- Gestão de perfil de utilizador individual, exceto email em cada conta criada
- Gestão de perfis de utilizadores por parte do administrador
- Registo de utilizadores manual pelo administrador
- Registo de utilizadores pelo próprio, garantindo a não duplicação de registos
- Utilizadores, no registo, devem selecionar (Distrito, Concelho)

## Gestão de Categorias

- Criação, edição e eliminação das mesmas
- Mostrar quantidade de itens por categoria

## Gestão de Produtos

- Criação, edição e eliminação das mesmas
- Produtos devem ter:
  - Preços
  - Imagem(s)
  - Título
  - Descrição
  - Categoria
- Na edição de produto, garantir que a imagem não é perdida em caso de update e que é substituída quando se faz update com nova imagem

## Funcionalidades do Administrador

- Visualizar totais de utilizadores por distrito e também por concelho
- Saber data de último acesso de cada conta

## Extra

- Ecrãs de frontend com montra de "loja" apresentando os produtos, visitáveis por categoria
- Permitir "encomenda" de cada item e, neste caso, mostrar no BackOffice as respetivas encomendas com data, utilizador e produto(s)

### Entrega

- Entrega em ZIP com o SQL utilizado
  