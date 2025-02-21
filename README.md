<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instalación

- Bajar repo.
- Instalar dependencias:
  - <code>composer install</code>
  - <code>npm i && npm run dev</code>
- Postman (el de tu preferencia)
  - <small>Agregar en los `headers` : `Accept : application/json`</small>
- Path: http::localhost:`8000`/api/`{...}`

> <small>Una vez iniciado sesión, no olvides colocar en los `headers` <small>
    Authorization : Bearer `<token>`


# POS API

REST API para una tienda.

#### Características

- <small>Registro/login/logout (clientes, vendedores)</small>
- <small>CRUD tiendas y productos</small>
- <small>Agregar/Eliminar producto de carrito (cliente)</small>
- <small>Finalizar compra (cliente) checkout</small>
- <small>Historial de compras (clientes)</small>
- <small>Historial de ventas (tienda para vendedores)</small>




## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
