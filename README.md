# HabilProf — Sistema de Gestión de Habilitaciones Profesionales
**Universidad Católica de la Santísima Concepción (UCSC)**  
**Facultad de Ingeniería**

HabilProf es una plataforma web desarrollada en **Laravel 12** y **Tailwind CSS 4** para la administración, supervisión y seguimiento de las Habilitaciones Profesionales (Proyectos de Ingeniería, Proyectos de Investigación y Prácticas Tuteladas) de la Facultad de Ingeniería de la UCSC.

---

## 📌 Origen y mejoras posteriores

Proyecto desarrollado en equipo para el ramo **Taller de Ingeniería de Software I** (2025), junto a [NicoValdebenito](https://github.com/NicoValdebenito), [Hbarrera1559](https://github.com/Hbarrera1559), [Natter21](https://github.com/Natter21) y [ConstanzaP1](https://github.com/ConstanzaP1). El repositorio original, con la versión entregada en Bootstrap, está en [NicoValdebenito/HabilProf](https://github.com/NicoValdebenito/HabilProf).

Después de la entrega continué el proyecto por mi cuenta (agosto–septiembre 2026):

- Migré todas las vistas de Bootstrap a **Tailwind CSS 4**: login, inicio, creación y edición de habilitaciones, listados, panel de administración e historial de sincronización.
- Creé los **modelos Eloquent** con sus relaciones (`Alumno`, `Profesor`, `HabilitacionProfesional`, `Pring`, `Prinv`, `PrTut`, `Supervisa`).
- Terminé la **creación de habilitaciones** y los **listados por semestre y por profesor**.
- Agregué **seeders con datos de ejemplo** para probar la aplicación sin la base de datos de la universidad.
- Corregí la **sincronización** con la base de datos externa y una migración de la tabla `Supervisa`.
- Agregué el middleware `PreventBackHistory`, que impide volver a páginas protegidas con el botón Atrás después de cerrar sesión.
- Actualicé dependencias con vulnerabilidades conocidas.

---

## 🚀 Stack Tecnológico

- **Backend:** PHP 8.2+ / 8.4 — Laravel 12.x
- **Base de Datos:** PostgreSQL 17 (Conexión principal `HabilProf` + Conexión externa de simulación `Modulos`)
- **ORM:** Eloquent ORM con relaciones completas (`Alumno`, `Profesor`, `HabilitacionProfesional`, `Pring`, `Prinv`, `PrTut`, `Supervisa`)
- **Frontend:** Blade Templates, Tailwind CSS 4.x, `@tailwindcss/vite`, ES6 JavaScript
- **Bundler:** Vite 7.x
- **Autenticación:** Laravel Auth adaptado para validación de **RUT chileno** y contraseñas Bcrypt
- **Seguridad:** Middleware `PreventBackHistory` (control estricto de cabeceras HTTP de caché tras Logout) y rutas protegidas con validación de roles

---

## 📋 Requisitos del Sistema

Antes de comenzar, asegúrate de contar con:

- **PHP** $\ge$ 8.2 con las siguientes extensiones activadas en `php.ini`:
  - `pdo_pgsql`, `pgsql`, `mbstring`, `openssl`, `fileinfo`, `zip`, `curl`
- **Composer** 2.x
- **Node.js** $\ge$ 18.x y **npm**
- **PostgreSQL** $\ge$ 15 (o Docker Desktop con **Laravel Sail**)
- **Git**

Comprobación rápida en consola:
```bash
php -v
composer -V
node -v
npm -v
```

---

## 🛠️ Instalación y Puesta en Marcha

### 1. Clonar el Repositorio
```bash
git clone https://github.com/Maanuus/HabilProf.git
cd HabilProf
```

### 2. Instalar Dependencias
Instala los paquetes de PHP y las dependencias de Node:
```bash
# Dependencias de PHP
composer install

# Dependencias de JavaScript y Tailwind CSS
npm install
```

### 3. Configurar Variables de Entorno
Copia el archivo de plantilla a tu entorno local:
```bash
cp .env.example .env
```
Genera la clave de aplicación de Laravel:
```bash
php artisan key:generate
```

### 4. Configurar la Base de Datos en `.env`
Edita tu archivo `.env` con las credenciales de tu servidor PostgreSQL:

```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=habilprof
DB_USERNAME=postgres
DB_PASSWORD=tu_password

# Conexión externa para simulación de sincronización con Modulos (opcional)
DB_ALUMNOS_HOST=127.0.0.1
DB_ALUMNOS_PORT=5432
DB_ALUMNOS_DATABASE=Modulos
DB_ALUMNOS_USERNAME=postgres
DB_ALUMNOS_PASSWORD=tu_password
```

*(Si utilizas Docker Sail, las credenciales por defecto son host `127.0.0.1`, puerto `5433`, usuario `sail` y password `password`).*

### 5. Ejecutar Migraciones y Poblado de Datos (Seeders)
Ejecuta las migraciones estructurales y llena la base de datos con los datos de prueba institucionales:
```bash
php artisan migrate:fresh --seed
```
Esto creará automáticamente:
- Usuarios administradores y de prueba.
- Catálogo de Alumnos y Profesores de la UCSC.
- Habilitaciones activas en todas las modalidades (Proyectos y Prácticas).

---

## 💻 Ejecución del Proyecto

Para trabajar en entorno de desarrollo, inicia el servidor de desarrollo y el compilador de assets:

Abre **dos terminales**:

**Terminal 1 — Servidor de Vite (Tailwind CSS y JavaScript):**
```bash
npm run dev
```

**Terminal 2 — Servidor de Aplicación Laravel:**
```bash
php artisan serve
```

La aplicación estará accesible en:  
👉 **`http://127.0.0.1:8000`** (o a través de Herd / Valet en `http://habilprof.test`).

---

## 👤 Credenciales de Acceso de Prueba

Al ejecutar los seeders, se crean usuarios listos para iniciar sesión:

| Rol | RUT de Acceso | Contraseña |
| :--- | :--- | :--- |
| **Administrador / Docente** | `12.345.678-9` | `password` |
| **Usuario Alternativo** | `19.876.543-2` | `password` |

*(El sistema acepta el RUT con puntos y guion, o solo números y dígito verificador).*

---

## 🌟 Módulos y Funcionalidades Principales

### 1. Panel Principal (Dashboard)
- Indicadores estadísticos en tiempo real: Total de habilitaciones activas, Proyectos de Ingeniería (`Pring`), Proyectos de Investigación (`Prinv`) y Prácticas Tuteladas (`PrTut`).
- Tabla con las **últimas 5 habilitaciones registradas** con badges de estado y formato condicional.

### 2. Creación y Edición de Habilitaciones
- Formulario reactivo que alterna automáticamente los campos según la modalidad elegida:
  - **Proyecto (Ingeniería / Investigación):** Título, descripción, profesor supervisor de comisión y profesor co-guía opcional.
  - **Práctica Tutelada:** Nombre de empresa patrocinadora y supervisor en terreno.
- Validación transaccional con actualización simultánea de alumno, habilitación y asignación de profesores supervisores.

### 3. Reportes y Listados
- **Listado Semestral:** Filtro por período académico (ej: `2024-1`) con opción de consulta histórica o específica.
- **Historial por Profesor:** Búsqueda por RUT docente que agrupa automáticamente las habilitaciones según el rol desempeñado (*Profesor Guía*, *Profesor Comisión*, *Tutor de Práctica*).

### 4. Simulación de Sincronización Externa (`Modulos`)
- Simula la integración entre el sistema departamental y el sistema central de registro curricular universitario (`Modulos`).
- **Detección de Incompletos:** Identifica alumnos o docentes locales con datos faltantes (correo o carrera).
- **Sincronización Inteligente:** Enriquecimiento automático desde la BD central sin sobrescribir datos válidos.
- **Sincronización de Notas:** Importa calificaciones oficiales y calcula el estado académico (*Aprobado* o *Reprobado*).
- **Auditoría:** Registro de cada cambio con valor anterior y valor nuevo visible en `/admin/sync-history`.

---

## 🔒 Ciberseguridad y Buenas Prácticas

- **Prevención de Retroceso en Caché (`bfcache`):** Middleware `PreventBackHistory` que inyecta cabeceras `Cache-Control: no-cache, no-store, must-revalidate` en todas las rutas privadas. Si el usuario cierra sesión y pulsa la flecha "Atrás" en su navegador, el sistema bloquea la visualización de datos en memoria y lo expulsa al login.
- **Protección de URLs y Privacidad:** Las búsquedas con datos personales viajan mediante el método `POST` para no registrar RUTs en historiales de navegación ni logs de proxy.
- **Protección contra IDOR:** Todas las rutas de edición e inspección están blindadas bajo middleware `auth`.

---

## ⚙️ Comandos Útiles

```bash
# Limpiar todas las cachés de Laravel (vistas, rutas, configuración)
php artisan optimize:clear

# Ejecutar sincronización con Modulos por consola
php artisan sync:modulos

# Ver rutas registradas en el sistema
php artisan route:list

# Compilar assets para despliegue en producción
npm run build
```

---

## 📄 Licencia y Créditos

Proyecto desarrollado para la **Universidad Católica de la Santísima Concepción (UCSC)**.  
Facultad de Ingeniería — Departamento de Ingeniería Civil Informática.