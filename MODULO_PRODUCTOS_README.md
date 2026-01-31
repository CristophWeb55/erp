# 📦 Módulo de Productos - Instalación y Uso

## 🚀 Instalación

### Paso 1: Ejecutar Migración de Base de Datos

Abre phpMyAdmin o tu cliente MySQL favorito y ejecuta los siguientes scripts en orden:

```bash
# 1. Migración para agregar campos nuevos
sql/migration_productos_stock.sql

# 2. (Opcional) Datos de ejemplo
sql/seed_productos_ejemplo.sql
```

### Paso 2: Verificar Archivos

Asegúrate de que los siguientes archivos se hayan actualizado/creado:

**Backend:**
- ✅ `app/models/Productos.php` - Modelo mejorado con stock
- ✅ `app/controllers/ProductosController.php` - Controlador con CRUD completo

**Frontend:**
- ✅ `app/views/productos/index.php` - Vista con tarjetas
- ✅ `app/views/productos/edit.php` - Vista de edición

**Base de Datos:**
- ✅ `sql/schema.sql` - Schema actualizado
- ✅ `sql/migration_productos_stock.sql` - Script de migración
- ✅ `sql/seed_productos_ejemplo.sql` - Datos de ejemplo

---

## 🎨 Características Implementadas

### ✅ Vista de Tarjetas Visuales
- Grid responsivo de productos
- Imágenes de productos (o placeholder)
- Diseño moderno con efectos hover

### ✅ Stock en Tiempo Real
- Cálculo automático desde `inventario_lotes`
- Barra de progreso visual
- Porcentaje de stock disponible

### ✅ Alertas de Stock
- **Verde**: Stock suficiente (>= stock_minimo)
- **Amarillo**: Stock bajo (< stock_minimo)
- **Rojo**: Sin stock (= 0)

### ✅ Badges Informativos
- Badge "Maneja Pedimento" para productos importados
- Badge de estado de stock

### ✅ Búsqueda en Tiempo Real
- Filtrado por SKU o nombre
- Búsqueda instantánea del lado del cliente

### ✅ CRUD Completo
- ✅ Crear productos
- ✅ Editar productos
- ✅ Eliminar productos (con confirmación)
- ✅ Ver detalle de productos

---

## 📊 Estructura de Datos

### Tabla `productos`

```sql
- id (PK)
- sku (UNIQUE)
- descripcion
- precio_venta
- costo_promedio
- stock_minimo        ← NUEVO
- imagen_url          ← NUEVO
- requiere_pedimento
- created_at
```

### Cálculo de Stock Actual

El stock actual se calcula sumando `cantidad_actual` de todos los lotes en `inventario_lotes`:

```sql
SELECT 
    p.*,
    COALESCE(SUM(il.cantidad_actual), 0) as stock_actual
FROM productos p
LEFT JOIN inventario_lotes il ON p.id = il.producto_id
GROUP BY p.id
```

---

## 🎯 Uso del Módulo

### Crear un Producto

1. Click en **"Nuevo Producto"**
2. Llenar formulario:
   - SKU / Código
   - Descripción
   - Precio de venta
   - Stock mínimo (default: 10)
   - URL de imagen (opcional)
   - Toggle "Requiere Pedimento"
3. Click en **"Registrar Producto"**

### Editar un Producto

1. Click en botón **"Editar"** en la tarjeta del producto
2. Modificar campos necesarios
3. Click en **"Guardar Cambios"**

### Eliminar un Producto

1. Click en botón de **basura** (🗑️)
2. Confirmar eliminación
3. El producto se elimina permanentemente

### Buscar Productos

1. Escribir en la barra de búsqueda superior
2. Los resultados se filtran automáticamente
3. Búsqueda por SKU o nombre

---

## 🎨 Personalización de Imágenes

### Opción 1: URLs Externas

Usa servicios como:
- Unsplash: `https://images.unsplash.com/photo-xxxxx?w=400`
- Imgur: `https://i.imgur.com/xxxxx.jpg`
- Tu propio servidor

### Opción 2: Imágenes Locales

1. Crear carpeta `public/assets/productos/`
2. Subir imágenes
3. Usar ruta relativa: `assets/productos/motor-001.jpg`

### Opción 3: Sin Imagen

Si no se proporciona imagen, se muestra un placeholder con ícono de caja.

---

## 📈 Cálculo de Barra de Progreso

```javascript
stockMax = stockMinimo * 2
porcentaje = (stockActual / stockMax) * 100
// Máximo 100%
```

**Ejemplo:**
- Stock mínimo: 10
- Stock actual: 15
- Stock máximo: 20
- Porcentaje: 75% (barra verde)

---

## 🔧 Solución de Problemas

### No se muestra el stock actual

**Problema:** Stock siempre aparece en 0

**Solución:** Verifica que existan registros en `inventario_lotes` para ese producto:

```sql
SELECT * FROM inventario_lotes WHERE producto_id = X;
```

### Las imágenes no cargan

**Problema:** Imágenes rotas o no se muestran

**Solución:**
1. Verifica que la URL sea válida
2. Verifica que la imagen sea accesible públicamente
3. Si usas HTTPS, las imágenes también deben ser HTTPS

### Error al editar producto

**Problema:** Error 404 o página en blanco

**Solución:** Verifica que exista el archivo `app/views/productos/edit.php`

---

## 🎯 Próximas Mejoras Sugeridas

- [ ] Subida de imágenes desde el formulario
- [ ] Exportar catálogo a PDF
- [ ] Importar productos desde Excel/CSV
- [ ] Categorías de productos
- [ ] Código de barras
- [ ] Historial de cambios de precio
- [ ] Productos relacionados
- [ ] Descuentos por volumen

---

## 📞 Soporte

Si tienes problemas con la implementación, verifica:

1. ✅ Migración ejecutada correctamente
2. ✅ Archivos en las rutas correctas
3. ✅ Permisos de escritura en carpetas necesarias
4. ✅ Conexión a base de datos funcionando

---

**¡Listo!** Tu módulo de productos está completamente funcional con diseño visual moderno. 🎉
