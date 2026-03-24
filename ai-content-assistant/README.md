Perfecto, te lo dejo ajustado con ese endpoint real 👇

---

# 🤖 AI Content API - Laravel

API desarrollada en Laravel para procesar texto utilizando inteligencia artificial.

---

## 📋 Requisitos

* PHP >= 8.1
* Composer
* (Opcional) Base de datos
* Servicio de IA corriendo (si aplica)

---

## ⚙️ Instalación

1. Clonar el repositorio:

```bash
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DEL_PROYECTO>
```

2. Instalar dependencias:

```bash
composer install
```

3. Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

---

## ▶️ Ejecutar la API

```bash
php artisan serve
```

Servidor disponible en:

```
http://127.0.0.1:8000
```

---

## 🧪 Endpoint principal

### 🔹 Procesar texto

**POST**

```
http://127.0.0.1:8000/api/process-text
```

---

## 📥 Ejemplo desde frontend (Axios)

```javascript
const response = await axios.post('http://127.0.0.1:8000/api/process-text', {
  text: inputText.value
})
```

---

## 📥 Ejemplo con curl

```bash
curl -X POST http://127.0.0.1:8000/api/process-text \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d "{\"text\":\"Hola mundo\"}"
```

---

## 📤 Respuesta esperada

```json
{
  "result": "Texto procesado por la IA..."
}
```

---

## ⚠️ Notas importantes

* El campo `text` es obligatorio.
* Asegúrate de que el backend de IA (si existe) esté corriendo.
* Si hay errores, revisa:

```bash
storage/logs/laravel.log
```

---

## 🚀 Estado

* ✅ Endpoint funcional
* ⏳ Despliegue pendiente

---

