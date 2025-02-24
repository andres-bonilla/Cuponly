# Cuponly  

## 🚀 Plataforma de Cupones Promocionales  

Cuponly es una aplicación web donde los usuarios pueden registrarse, ver ofertas y generar códigos promocionales únicos. Luego, pueden consultar sus códigos guardados y marcarlos como canjeados.  

El proyecto está dividido en dos partes:  

- Un backend en **Laravel** que maneja la lógica de la aplicación y la base de datos (**SQLite**).  
- Un frontend en **React** que muestra la interfaz y permite a los usuarios interactuar con la plataforma.  

También se usa **Laravel Sanctum** para la autenticación.  

### 🔹 Funcionalidades principales  

✅ Registro e inicio de sesión.  
✅ Ver lista de cupones disponibles.   
✅ Consultar los cupones obtenidos.  
✅ Marcar cupones como canjeados.  
✅ Generar códigos únicos al canjear los cupones. 

---  

## 📂 Estructura del Proyecto  

```bash
├── /back   # Backend (Laravel 11)
└── /front  # Frontend (React 19)
```

## 🛠️ Requisitos Previos  

Antes de empezar, asegúrate de tener instalado en tu sistema:  

- [PHP 8.2+](https://www.php.net/downloads) y Composer  
- [Node.js 18+](https://nodejs.org/) y npm  
- [SQLite](https://www.sqlite.org/download.html)  
- Git  

## 🚀 Instalación  

### 🔹 Clonar el repositorio  

```bash
git clone https://github.com/andres-bonilla/Cuponly.git
cd Cuponly
```

---

### 🔹 Configurar el Backend (Laravel)  

1. Ve a la carpeta del backend:  

   ```bash
   cd back
   ```

2. Instala las dependencias:  

   ```bash
   composer install
   ```

3. Copia el archivo de entorno:  

   ```bash
   cp .env.example .env
   ```

4. Genera la clave de la aplicación:  

   ```bash
   php artisan key:generate
   ```

5. Crea el archivo de la base de datos:  

   ```bash
   touch database/database.sqlite
   ```

6. Ejecuta las migraciones y el seeder para generar los cupones iniciales:  

   ```bash
   php artisan migrate --seed
   ```

7. Inicia el servidor:  

   ```bash
   php artisan serve
   ```

El backend estará disponible en `http://127.0.0.1:8000`

---

### 🔹 Configurar el Frontend (React)  

1. Ve a la carpeta del frontend:  

   ```bash
   cd ../front
   ```

2. Instala las dependencias:  

   ```bash
   npm install
   ```

3. Copia el archivo de entorno:  

   ```bash
   cp .env.example .env
   ```

   Dentro de `.env`, podras encontrar la url de la API:  

   ```
   VITE_API_URL=http://127.0.0.1:8000/api
   ```

4. Inicia el frontend:  

   ```bash
   npm run dev
   ```

El frontend estará disponible en la URL que te muestre Vite (por defecto algo como `http://localhost:5173`).

