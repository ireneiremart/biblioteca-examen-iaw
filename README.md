# Biblioteca

Aplicació PHP bàsica per gestionar llibres de l'empresa NextTolken S.A.. No utilitza cap framework.

## Posada en marxa

1. Copia la carpeta `biblioteca` dins de l'arrel del servidor web, per exemple `/var/www/html/`.
2. Instal·la php, nginx i el que necessites.
3. Crea l'usuari de MySQL amb permisos suficients per crear i esborrar la base de dades:

4. Visita `http://ip_server/biblioteca/` i prem **Inicialitzar**. Es crearà la base de dades `iaw_biblioteca`.

## Configuració

Els paràmetres de MySQL, el nom de la taula, les mides dels camps i el mètode dels formularis es troben en `config.php`.

El mètode predeterminat és `get`. Per canviar-lo a POST:

```php
define('FORM_METHOD', 'post');
```

Les caixes de text utilitzen la clau `size` de `FIELDS` tant per a `size` com per a `maxlength`, i la clau `sql` s'utilitza per construir la taula `Llibres`.
