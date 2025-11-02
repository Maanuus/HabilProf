# HabilProf — Puesta en marcha local (Laravel 12 + Bootstrap)

Este proyecto está preparado para ejecutarse como **mockup** (sin BD).

---

## Requisitos

- **PHP** ≥ 8.2 con extensiones: `fileinfo`, `zip`, `mbstring`, `openssl`, `pdo_pgsql`, `pgsql`
- **Composer** 2.x
- **Node.js** 18 o superior y **npm**
- **Git** (o GitHub Desktop)

Comprobaciones:
```bash
php -v
composer -V
node -v
npm -v
```

Clonación del proyeto desde GitHub utilizando Git:

``` bash
git clone https://github.com/NicoValdebenito/HabilProf
cd HabilProf
```

**La otra opción es clonarlo desde GitHub Desktop**

#### Ejecución como mockup

- **Instalación de dependencias**

```bash
cp .env.example .env

php artisan key:generate
```

Para ejecutar el proyecto se deben abrir dos terminales.

La primera (esta se deja abierta en segundo plano)
```bash
npm run dev   
```
y la segunda (esta abre el servidor local donde se ejecutará la web)
```bash
php artisan serve
```

Estas son las rutas visibles y que son buenas de conocer:

Inicio (login mockup): http://127.0.0.1:8000/

Principal (welcome): http://127.0.0.1:8000/home

Nueva habilitación (form): http://127.0.0.1:8000/habilitaciones/nueva