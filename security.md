# Medidas de seguridad

## 1. Autenticación y autorización
- Sistema de inicio de sesión con usuario y contraseña.
- Clase `AuthGuard` que gestiona permisos y redirecciones.
- Métodos específicos para:
  - `requireAuth()`: Verifica que el usuario esté autenticado.
  - `requireNoAuth()`: Asegura acceso solo para usuarios no autenticados.
  - `requireAdmin()`: Verifica permisos de administrador.

## 2. Cifrado
- Contraseñas procesadas con `password_hash()` utilizando algoritmos seguros.
- Verificación de contraseñas con `password_verify()`.
- Rehash automático de contraseñas obsoletas durante login.
- No se almacenan contraseñas en texto plano en ningún momento.

## 3. Seguridad de sesión
- Regeneración de ID de sesión después del inicio de sesión (`session_regenerate_id(true)`).
- Clase `Session` para administrar datos de sesión de forma segura.
- Verificación de roles para controlar acceso a funcionalidades.
- Mecanismo de cierre de sesión implementado correctamente.

## 4. Protección contra ataques comunes
- Sanitización de entradas con `sanitizar()` que implementa:
  - `trim()`: Elimina espacios.
  - `stripslashes()`: Elimina barras invertidas.
  - `htmlspecialchars()`: Convierte caracteres especiales en entidades HTML.
- Validación de correos electrónicos con `filter_var()`.
- Validación de contraseñas con reglas estrictas (longitud, mayúsculas, minúsculas, números, caracteres especiales).

## 5. Registro y monitoreo
- Registro de intentos de acceso en la base de datos.
- Almacenamiento de IP, nombre de usuario y resultado del intento.
- Función `getClientIp()` para identificar direcciones IP de manera confiable.
