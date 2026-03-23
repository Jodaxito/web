# 🚀 JODAXI Deploy en Railway + PostgreSQL

Guía completa y lista para implementar tu aplicación Laravel en Railway con base de datos PostgreSQL.

---

## 📋 Requisitos previos

- ✅ Proyecto en GitHub: `https://github.com/dg860177-hash/jodaxi` (rama `main`)
- ✅ Cuenta en [Railway.app](https://railway.app)
- ✅ PHP 8.2+ local (para generar APP_KEY)

---

## Paso 1: Generar APP_KEY

Ejecuta localmente en tu proyecto:

```bash
php artisan key:generate --show
```

Copia el valor que aparece (ej: `base64:xxxxx...`)

---

## Paso 2: Crear proyecto en Railway

1. Ve a [railway.app](https://railway.app)
2. Haz login o crea cuenta
3. New Project → Deploy from GitHub
4. Autoriza acceso a GitHub
5. Selecciona:
   - Repository: `dg860177-hash/jodaxi`
   - Branch: `main`
6. Railway crea automáticamente un servicio que detecta PHP

---

## Paso 3: Agregar PostgreSQL

En tu proyecto Railway:

1. `Add` → `Add Plugin` → `PostgreSQL`
2. Railway crea automáticamente la BD con variables de entorno

---

## Paso 4: Configurar Variables de Entorno

### Ubicación en Railway:
- Tu proyecto → Tab `Variables`

### Variables a copiar/pegar exactamente:

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:XXX... (pega tu valor de arriba)
APP_URL=https://<railway-url>
APP_NAME=JODAXI
APP_LOCALE=es
LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=${Postgres.PGHOST}
DB_PORT=${Postgres.PGPORT}
DB_DATABASE=${Postgres.PGDATABASE}
DB_USERNAME=${Postgres.PGUSER}
DB_PASSWORD=${Postgres.PGPASSWORD}
DB_SCHEMA=public
DB_SSLMODE=require

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
FILESYSTEM_DISK=local
```

**Nota:** Los valores entre `${}` los reemplaza Railway automáticamente desde el plugin de Postgres.

---

## Paso 5: Configurar Build & Deploy

En Railway, en tu servicio PHP:

### Variables de entorno disponibles:

La mayoría de valores quedan automáticos. Solo revisa:
- `${Postgres.PGHOST}`, `${Postgres.PGPORT}`, etc. se generan del plugin

### (Opcional) Build Command personalizado

Si Railway no detecta PHP automáticamente:

```bash
composer install --no-dev --optimize-autoloader && php artisan migrate --force
```

### Start Command

Verifica que sea algo como:

```bash
php -S 0.0.0.0:8080 -t public
```

o Railway lo detecta por defecto.

---

## Paso 6: Ejecutar migraciones y seeders

Una vez desplegado, ejecuta en Railway Terminal (si está disponible) o en Post Deploy Hook:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
```

O añade a `.env`:

```
APP_MAINTENANCE_DRIVER=
```

---

## Paso 7: Prueba en vivo

Después del deploy, abre tu URL Railway (encontrada en su dashboard) y prueba:

- `https://tu-app.railway.app/` (home)
- `https://tu-app.railway.app/market` (marketplace)
- Registro / Login
- CRUD básico

---

## 🔧 Troubleshooting

### Error: `SQLSTATE[08006]`
**Causa:** DB no conecta.  
**Fix:**
- Revisa `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` en Railway Variables
- Asegúrate que el PostgreSQL plugin esté activo
- Prueba temporal `APP_DEBUG=true` para ver logs detallados

### Error: `Connection refused`
**Causa:** PostgreSQL no disponible aún.  
**Fix:**
- Espera 2-3 min a que Railway inicie el DB
- Redeploy tu app después

### Error: `file_get_contents(storage/...)`
**Causa:** Storage no linkedado.  
**Fix:**
```bash
php artisan storage:link
```

### Logs de error
En Railway → Logs → Ver último deploy error.  
Temporalmente `APP_DEBUG=true` para más detalles.

---

## 📝 Estructura de archivos local

Tu `.env` local debe ser (para desarrollo):

```
APP_KEY=base64:...
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=jodaxi_dev
DB_USERNAME=postgres
DB_PASSWORD=tu_password_local
DB_SSLMODE=prefer
```

---

## ✅ Checklist final

- [ ] `APP_KEY` generado y pegado en Railway
- [ ] PostgreSQL plugin agregado
- [ ] Todas las variables `DB_` configuradas con valores de Postgres
- [ ] `APP_URL` válida (Railway te da la URL)
- [ ] Deploy disparado (Git push a `main`)
- [ ] Migraciones ejecutadas (`php artisan migrate --force`)
- [ ] Home page carga sin errores

---

## 📞 Paso siguiente

Si todo carga:
- ✅ **Completado:** JODAXI está en producción con:
  - ✨ Diseño verde moderno
  - 🖼️ Logo integrado
  - 📦 PostgreSQL en la nube
  - 🚀 Deploy automático desde GitHub

Si hay error, revisa logs en Railway o comparte el error exacto.

---

**Créado:** 23 de marzo de 2026  
**Proyecto:** JODAXI v1.0  
**Hosting:** Railway + PostgreSQL
