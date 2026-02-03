# Guía de Actualización de Base de Datos - URICA ERP

Esta guía explica cómo mantener sincronizada tu base de datos local con los cambios más recientes del repositorio.

## 🚀 Pasos para Actualizar

Cuando realices un `git pull` y veas cambios en la estructura, sigue estos pasos:

### 1. Ejecutar Migraciones Automáticas
En la carpeta `public/` existen scripts de migración que actualizan la estructura sin borrar tus datos actuales.

**Debes ejecutarlos desde tu navegador:**
- **Soft Delete en Productos:** `http://localhost/erp/public/migration_soft_delete_productos.php`
- **Soft Delete General:** `http://localhost/erp/public/migration_soft_delete.php`

> **Nota:** Si tu ruta local es diferente (ej. `http://localhost/proyecto-erp/`), ajusta la URL según corresponda.

### 2. Instalación desde Cero
Si estás instalando el proyecto por primera vez:
1. Crea una base de datos llamada `erp_pedimentos`.
2. Importa el archivo `sql/schema.sql`. Este archivo siempre tiene la estructura completa y actualizada.

### 3. Configuración de IA (Nuevo)
Para que el Asistente IA funcione, debes asegurarte de que el archivo `config/ai_config.php` tenga una API Key válida de Gemini.
- Si no tienes el archivo, puedes copiarlo de un compañero o pedir la clave al administrador.

---

## 🛠️ Notas para Desarrolladores
- **NUNCA** modifiques el `schema.sql` directamente sin avisar al equipo.
- Si agregas una columna nueva, crea un script en `public/migration_nombre_cambio.php` para que todos podamos actualizar fácilmente.
