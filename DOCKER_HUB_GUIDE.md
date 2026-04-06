# Guía para Subir Jodaxi a Docker Hub

## Requisitos Previos

1. **Cuenta en Docker Hub**: Regístrate en [https://hub.docker.com/](https://hub.docker.com/)
2. **Docker instalado**: Asegúrate de tener Docker Desktop instalado y funcionando

## Pasos para Subir a Docker Hub

### 1. Iniciar Sesión en Docker Hub desde la Terminal

```bash
docker login
```

Se te pedirá:
- **Username**: Tu nombre de usuario de Docker Hub
- **Password**: Tu contraseña de Docker Hub
- **Email**: Tu correo electrónico

### 2. Construir la Imagen de Docker

Desde la raíz del proyecto, ejecuta:

```bash
docker build -t jodaxi .
```

Para verificar que la imagen se creó correctamente:

```bash
docker images
```

Deberías ver algo como:
```
REPOSITORY   TAG       IMAGE ID       CREATED        SIZE
jodaxi       latest    xxxxxxxxxxxx   2 minutes ago  450MB
```

### 3. Etiquetar la Imagen para Docker Hub

Reemplaza `TU_USUARIO` con tu nombre de usuario de Docker Hub:

```bash
docker tag jodaxi TU_USUARIO/jodaxi:latest
```

### 4. Subir la Imagen a Docker Hub

```bash
docker push TU_USUARIO/jodaxi:latest
```

Esto puede tardar varios minutos dependiendo de tu conexión a internet.

### 5. Verificar en Docker Hub

1. Ve a [https://hub.docker.com/](https://hub.docker.com/)
2. Inicia sesión con tu cuenta
3. Verás tu repositorio `jodaxi` listado

---

## Comandos Útiles

### Descargar tu Imagen desde Docker Hub

```bash
docker pull TU_USUARIO/jodaxi:latest
```

### Ejecutar tu Imagen

```bash
docker run -d -p 8080:8080 --name jodaxi-app TU_USUARIO/jodaxi:latest
```

### Detener y Eliminar el Contenedor

```bash
docker stop jodaxi-app
docker rm jodaxi-app
```

### Ver Logs del Contenedor

```bash
docker logs -f jodaxi-app
```

---

## Usar docker-compose con la Imagen de Docker Hub

Crea un archivo `docker-compose-production.yml`:

```yaml
version: '3.8'

services:
  db:
    image: mysql:8.0
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_USER: ${DB_USERNAME}
      MYSQL_PASSWORD: ${DB_PASSWORD}
    ports:
      - "3306:3306"
    volumes:
      - dbdata:/var/lib/mysql

  app:
    image: TU_USUARIO/jodaxi:latest
    depends_on:
      - db
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
      - DB_CONNECTION=mysql
      - DB_HOST=db
      - DB_PORT=3306
      - DB_DATABASE=${DB_DATABASE}
      - DB_USERNAME=${DB_USERNAME}
      - DB_PASSWORD=${DB_PASSWORD}
      - APP_KEY=${APP_KEY}
    ports:
      - "8080:8080"
    volumes:
      - ./storage:/var/www/html/storage
    command: >
      sh -c "php artisan migrate --force &&
             php artisan serve --host=0.0.0.0 --port=8080"

volumes:
  dbdata:
```

Para ejecutarlo:

```bash
docker-compose -f docker-compose-production.yml up -d
```

---

## Actualizar la Imagen en Docker Hub

Si haces cambios en tu código:

1. Reconstruye la imagen localmente:
   ```bash
   docker build -t jodaxi .
   ```

2. Etiqueta con la nueva versión:
   ```bash
   docker tag jodaxi TU_USUARIO/jodaxi:v1.0.1
   docker tag jodaxi TU_USUARIO/jodaxi:latest
   ```

3. Sube las nuevas etiquetas:
   ```bash
   docker push TU_USUARIO/jodaxi:v1.0.1
   docker push TU_USUARIO/jodaxi:latest
   ```

---

## Configuración de Variables de Entorno

La imagen espera las siguientes variables de entorno en producción:

| Variable | Descripción | Ejemplo |
|----------|-------------|---------|
| APP_KEY | Clave de aplicación Laravel | `base64:xxxxxxx...` |
| DB_HOST | Host de la base de datos | `db` |
| DB_PORT | Puerto de MySQL | `3306` |
| DB_DATABASE | Nombre de la base de datos | `campus_market` |
| DB_USERNAME | Usuario de la base de datos | `user` |
| DB_PASSWORD | Contraseña de la base de datos | `secret` |
| APP_ENV | Entorno (production/local) | `production` |
| APP_DEBUG | Modo debug (true/false) | `false` |

---

## Notas Importantes

1. **APP_KEY**: La imagen genera automáticamente una clave si no se proporciona, pero para producción es mejor configurar una fija.

2. **Base de datos**: La imagen requiere MySQL. Asegúrate de tener una instancia de MySQL disponible o usa docker-compose.

3. **Volúmenes**: Para persistencia de datos (uploads, logs), monta los directorios necesarios:
   - `./storage:/var/www/html/storage`

4. **Puertos**: La aplicación usa el puerto 8080 internamente.

---

## Soporte

Si tienes problemas, consulta la documentación oficial de Docker:
- [Docker Hub](https://docs.docker.com/docker-hub/)
- [Dockerfile reference](https://docs.docker.com/engine/reference/builder/)
