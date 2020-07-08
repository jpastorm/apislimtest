# REST API ApiSlimTest

Este es un ejemplo básico de una REST API que proporciona un REST API . Toda la aplicación está contenida dentro del archivo `src`.

## Install

    composer install

## Run the app

    {host}/public

# REST API

La API REST para la aplicación de ejemplo se describe a continuación.



## Obtener avatar de un usuario

### Request

`GET /public/search/{username}`

### Parameters
- **username** - Nombre de un usuario registrado

### Response
- **avatar** - avatar del usuario registrado

### Errors
- **ErrorCode1** - Woops, tuvimos un error- `500`
- **ErrorCode2** - No se especifico nada para buscar- `404`

### Example Request
`GET /public/search/{username}`

### Example Response
`200 OK`

```javascript
{
	avatar: "{HOST}/avatar.png"
}
```
## Login

### Request

`POST /public/login`

### Parameters
- **username** - Nombre del usuario registrado
- **password** - Contraseña del usuario registrado

### Body
- **username** - Nombre del usuario registrado
- **password** - Contraseña del usuario registrado

### Response

Los tokens pueden ser verificados en [jwt.io](https://jwt.io/ "JWT Homepage")

**Token de ejemplo :**

- **token** - eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c

### Errors
- **ErrorCode1** - Datos Incompletos- `400`
- **ErrorCode2** - El campo username es invalido- `400`
- **ErrorCode3** - El campo password es invalido- `400`
- **ErrorCode4** - No se encontro el usuario en la base de datos- `401`

### Example Request
`POST /public/login`

### Example Response
`200 OK`

```javascript
{
	token: "{example token}"
}
```
## Registrar usuario

### Request

`POST /public/adduser`

### Parameters
- **username** - Nombre del usuario a registrar
- **password** - Contraseña del usuario a registrar
- **email** - Email del usuario a registrar

### Body
- **username** - Nombre del usuario a registrar
- **password** - Contraseña del usuario a registrar
- **email** - Email del usuario a registrar

### Response

- **mensaje** - Mensaje de verificación

### Errors
- **ErrorCode1** - Datos Incompletos- `400`
- **ErrorCode2** - El campo username es invalido- `400`
- **ErrorCode3** - El campo password es invalido- `400`
- **ErrorCode4** - El campo email es invalido- `400`
- **ErrorCode5** - Woops!, Hubo un problema- `500`

### Example Request
`POST /public/adduser`

### Example Response
`201 OK`

```javascript
{
	message: "Se creo correctamente el usuario"
}
```
## Subir  avatar

### Request

`POST /public/upload`

### Headers
- **Authorization** - Identifica la sesion actual con un token

### Body
- **file** - Archivo que se subira al servidor como un avatar

### Response

- **mensaje** - Mensaje de verificacion

### Errors
- **ErrorCode1** - Woops!, Hubo un problema- `500`
- **ErrorCode2** - No se subio el archivo D: - `400`
- **ErrorCode3** - Formato incorrecto, Solo se aceptan PNG D:- `400`
- **ErrorCode4 ** - Invalid token supplied- `401`

### Example Request
`POST /public/upload`

### Example Response
`200 OK`

```javascript
{
	message: "Avatar actualizado"
}
```

