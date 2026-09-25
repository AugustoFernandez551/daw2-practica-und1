# PRÁCTICA CALIFICADA – UNIDAD I
## Desarrollo de Aplicaciones Web II – V ciclo

Este repositorio contiene la estructura base para desarrollar la **Práctica Calificada de Laboratorio de la Unidad I**.

La práctica es **individual** y tendrá una duración máxima de **50 minutos**.

Durante la evaluación, el docente indicará a cada estudiante cuál de las siguientes variantes deberá desarrollar:

| Variante | Caso asignado | Entidad principal |
|---|---|---|
| **A** | Préstamo de equipos de laboratorio | `Prestamo` |
| **B** | Incidencias de soporte TI | `Incidencia` |
| **C** | Inventario de equipos informáticos | `Equipo` |

La variante asignada será verificada por el docente durante la práctica.

---

# 1. ¿QUÉ SE EVALUARÁ?

Durante la práctica deberá demostrar el uso de:

- PHP.
- Programación Orientada a Objetos.
- PDO.
- Sentencias preparadas.
- Namespaces.
- Autoload.
- Arquitectura básica por capas.
- DTO.
- DAO.
- BO.
- Formularios mediante `GET` y `POST`.
- Git y GitHub.

No se utilizará:

- Composer.
- Frameworks PHP.
- MVC.
- Frameworks de frontend.
- JavaScript avanzado.

---

# 2. ESTRUCTURA DEL PROYECTO

El repositorio contiene inicialmente:

```text
daw2-practica-und1/
│
├── bo/
│
├── config/
│   └── Autoload.php
│
├── dao/
│   └── Conexion.php
│
├── database/
│   └── practica.sql
│
├── dto/
│
├── tests/
│   └── evaluar.php
│
├── .github/
│   └── workflows/
│       └── evaluacion.yml
│
├── index.php
└── README.md
```

Dependiendo de la variante asignada, deberá crear sus propios archivos dentro de:

```text
dto/
dao/
bo/
```

---

# 3. ARCHIVOS QUE NO DEBE MODIFICAR

Los siguientes archivos forman parte de la infraestructura de la práctica y de la evaluación automática.

**NO DEBEN SER MODIFICADOS:**

```text
config/Autoload.php

dao/Conexion.php

database/practica.sql

tests/

.github/
```

El docente detectará modificaciones realizadas sobre estos archivos. De ser asi, se le calificará con nota mínima (00).

---

# 4. PREPARACIÓN DE LA BASE DE DATOS

Antes de comenzar el desarrollo:

1. Inicie **Apache** y **MySQL** desde XAMPP.
2. Ingrese a `phpMyAdmin`.
3. Importe el archivo:

```text
database/practica.sql
```

Este archivo creará automáticamente la base de datos:

```text
practica_daw2_und1
```

La base contiene las tablas necesarias para las tres variantes.

---

# 5. ENTREGA MEDIANTE GITHUB

La entrega de la práctica se realizará mediante:

```text
FORK
   ↓
CLONE
   ↓
CREAR RAMA
   ↓
PROGRAMAR
   ↓
COMMIT
   ↓
PUSH
   ↓
PULL REQUEST
   ↓
PEGAR LINK DEL PR EN MOODLE
```

A continuación se explica cada paso.

---

# PASO 1. HACER FORK DEL REPOSITORIO

El **Fork** permite crear una copia del repositorio del docente dentro de su propia cuenta de GitHub.

### 1.1 Ingrese al repositorio proporcionado por el docente.

Debe encontrarse en el repositorio original de la práctica.

### 1.2 En la parte superior derecha presione:

```text
Fork
```

### 1.3 GitHub mostrará la ventana:

```text
Create a new fork
```

No necesita cambiar el nombre del repositorio.

### 1.4 Presione:

```text
Create fork
```

Espere unos segundos.

GitHub lo enviará automáticamente a una copia del repositorio dentro de **su propia cuenta**.

Por ejemplo:

```text
Repositorio original:

github.com/EderNick/daw2-practica-und1
```

Después del Fork:

```text
github.com/juanperez/daw2-practica-und1
```

> IMPORTANTE: A partir de este momento debe trabajar con el repositorio que se encuentra en **su propia cuenta de GitHub**.

---

# PASO 2. COPIAR LA URL DE SU FORK

Dentro de su repositorio personal:

### 2.1 Presione el botón:

```text
<> Code
```

### 2.2 Seleccione:

```text
HTTPS
```

### 2.3 Copie la URL mostrada.

Ejemplo:

```text
https://github.com/juanperez/daw2-practica-und1.git
```

Asegúrese de que la URL contenga **su usuario de GitHub**.

---

# PASO 3. CLONAR EL REPOSITORIO

Clonar significa descargar el repositorio desde GitHub hacia la computadora.

Abra una terminal.

Puede utilizar:

- Terminal de VS Code.
- Git Bash.
- PowerShell.
- CMD.

Ubíquese en la carpeta donde trabajará.

Por ejemplo, si utiliza XAMPP:

```bash
cd C:\xampp\htdocs
```

Ejecute:

```bash
git clone URL-DE-SU-FORK
```

Ejemplo:

```bash
git clone https://github.com/juanperez/daw2-practica-und1.git
```

Espere hasta que finalice la descarga.

---

# PASO 4. INGRESAR A LA CARPETA DEL PROYECTO

Ejecute:

```bash
cd daw2-practica-und1
```

Puede verificar los archivos con:

```bash
dir
```

o desde VS Code abrir la carpeta:

```text
Archivo → Abrir carpeta
```

Seleccione:

```text
daw2-practica-und1
```

---

# PASO 5. CREAR SU RAMA PERSONAL

**NO debe trabajar directamente en `main`.**

Cada estudiante deberá crear una rama con el siguiente formato:

```text
practica/nombre-completo
```

Ejemplo:

```text
practica/juan-carlos-perez-lopez
```

Utilice:

- letras minúsculas;
- guiones;
- sin espacios;
- sin tildes;
- sin `ñ`.

Ejecute:

```bash
git checkout -b practica/juan-carlos-perez-lopez
```

Reemplace el nombre del ejemplo por sus propios nombres y apellidos.

---

# PASO 6. VERIFICAR QUE ESTÁ EN SU RAMA

Ejecute:

```bash
git branch
```

Debe aparecer algo similar a:

```text
  main
* practica/juan-carlos-perez-lopez
```

El símbolo:

```text
*
```

indica la rama en la que está trabajando.

Debe estar ubicado en:

```text
practica/nombre-completo
```

y **no en `main`**.

---

# PASO 7. IDENTIFICAR SU VARIANTE

El docente le indicará cuál variante deberá resolver.

## VARIANTE A

```text
Préstamo de equipos de laboratorio
```

Deberá crear:

```text
dto/Prestamo.php
dao/Prestamo.php
bo/Prestamo.php
```

---

## VARIANTE B

```text
Incidencias de soporte TI
```

Deberá crear:

```text
dto/Incidencia.php
dao/Incidencia.php
bo/Incidencia.php
```

---

## VARIANTE C

```text
Inventario de equipos informáticos
```

Deberá crear:

```text
dto/Equipo.php
dao/Equipo.php
bo/Equipo.php
```

---

# PASO 8. DESARROLLAR LA PRÁCTICA

Deberá implementar la solución correspondiente a su variante utilizando las capas:

```text
index.php
    ↓
BO
    ↓
DAO
    ↓
PDO
    ↓
Base de datos
```

El DTO representa los datos de la entidad.

El DAO realiza las operaciones con la base de datos.

El BO administra las operaciones del negocio.

Las funciones obligatorias indicadas para la práctica son:

```php
registrar()

listar()

buscar()

cambiarEstado()
```

También deberá completar la integración correspondiente dentro de:

```text
index.php
```

---

# PASO 9. PROBAR SU APLICACIÓN

Antes de enviar el trabajo, verifique desde el navegador que pueda realizar:

```text
REGISTRAR
```

```text
LISTAR
```

```text
BUSCAR
```

```text
CAMBIAR ESTADO
```

Por ejemplo:

```text
http://localhost/daw2-practica-und1/
```

No continúe con la entrega sin realizar previamente sus pruebas.

---

# PASO 10. VERIFICAR LOS ARCHIVOS MODIFICADOS

En la terminal ejecute:

```bash
git status
```

Git mostrará los archivos que fueron creados o modificados.

Revise que correspondan a su trabajo.

Recuerde que **NO debe modificar**:

```text
config/Autoload.php

dao/Conexion.php

database/practica.sql

tests/

.github/
```

---

# PASO 11. AGREGAR LOS CAMBIOS

Ejecute:

```bash
git add .
```

Este comando prepara todos los cambios realizados para guardarlos mediante Git.

Puede verificar nuevamente:

```bash
git status
```

---

# PASO 12. CREAR EL COMMIT

Ejecute:

```bash
git commit -m "Resolver practica Unidad I"
```

El commit registra el avance realizado.

---

# PASO 13. SUBIR SU RAMA A GITHUB

La primera vez deberá utilizar:

```bash
git push -u origin practica/nombre-completo
```

Ejemplo:

```bash
git push -u origin practica/juan-carlos-perez-lopez
```

Espere hasta que Git termine de subir los archivos.

---

# PASO 14. VERIFICAR LOS CAMBIOS EN GITHUB

Ingrese nuevamente a su Fork desde el navegador.

Deberá observar un mensaje similar a:

```text
practica/juan-carlos-perez-lopez
had recent pushes
```

También aparecerá el botón:

```text
Compare & pull request
```

Presiónelo.

---

# PASO 15. CREAR EL PULL REQUEST

Un **Pull Request (PR)** permitirá enviar su solución desde su Fork hacia el repositorio original del docente.

Antes de crear el PR, verifique cuidadosamente:

```text
Base repository:
Repositorio del docente
```

```text
Base:
main
```

```text
Head repository:
Su Fork
```

```text
Compare:
practica/nombre-completo
```

Ejemplo:

```text
base:

EderNick/daw2-practica-und1
main
```

```text
compare:

juanperez/daw2-practica-und1
practica/juan-carlos-perez-lopez
```

---

# PASO 16. COMPLETAR LA PLANTILLA DEL PULL REQUEST

GitHub mostrará automáticamente una plantilla.

Complete:

```text
Apellidos y nombres
```

```text
Usuario de GitHub
```

```text
Rama utilizada
```

y marque la variante asignada:

```text
[ ] A – Préstamo de equipos de laboratorio

[ ] B – Incidencias de soporte TI

[ ] C – Inventario de equipos informáticos
```

Después complete el checklist de verificación.

No elimine la plantilla.

---

# PASO 17. CREAR EL PULL REQUEST

Finalmente presione:

```text
Create pull request
```

Su entrega quedará registrada en el repositorio del docente.

---

# PASO 18. REVISIÓN AUTOMÁTICA CON GITHUB ACTIONS

Después de crear el Pull Request, GitHub iniciará automáticamente la revisión del proyecto.

Puede aparecer un indicador:

```text
Pending
```

```text
In progress
```

o:

```text
Checks running
```

Espere hasta que finalice.

GitHub Actions verificará automáticamente diferentes aspectos del proyecto, entre ellos:

- estructura de carpetas;
- DTO;
- POO;
- namespaces;
- autoload;
- uso de PDO;
- sentencias preparadas;
- registro;
- listado;
- búsqueda;
- cambio de estado;
- integración con `index.php`;
- nombre de la rama;
- archivos protegidos.

La evaluación utiliza:

```text
Cumple      = 2 puntos

Parcial     = 1 punto

No cumple   = 0 puntos
```

Máximo:

```text
20 puntos
```

---

# PASO 19. SI NECESITA REALIZAR UNA CORRECCIÓN

Si después de crear el Pull Request encuentra un error, **NO cree otro Pull Request**.

Corrija el archivo desde VS Code.

Después ejecute nuevamente:

```bash
git status
```

```bash
git add .
```

```bash
git commit -m "Corregir practica"
```

```bash
git push
```

Como la rama ya está conectada con GitHub, no necesita volver a escribir:

```text
-u origin nombre-rama
```

Su Pull Request se actualizará automáticamente.

GitHub Actions volverá a ejecutar la revisión.

---

# PASO 20. COPIAR EL ENLACE DEL PULL REQUEST

Una vez creado el Pull Request, observe la barra de direcciones del navegador.

El enlace tendrá una estructura similar a:

```text
https://github.com/EderNick/daw2-practica-und1/pull/15
```

Copie **el enlace del Pull Request**.

No copie:

- el enlace de su Fork;
- el enlace de su perfil;
- el enlace de la rama;
- el enlace de un archivo.

Debe copiar específicamente el enlace que contiene:

```text
/pull/
```

Ejemplo correcto:

```text
https://github.com/EderNick/daw2-practica-und1/pull/15
```

---

# PASO 21. ENTREGAR LA EVIDENCIA EN MOODLE

Ingrese a la actividad correspondiente en Moodle.

En el espacio de entrega pegue:

```text
URL de su Pull Request
```

Ejemplo:

```text
https://github.com/EderNick/daw2-practica-und1/pull/15
```

Guarde o envíe la actividad según corresponda.

El enlace del Pull Request será considerado la **evidencia oficial de entrega de la práctica**.

---

# RESUMEN DE COMANDOS GIT

## Clonar su Fork

```bash
git clone https://github.com/USUARIO/daw2-practica-und1.git
```

## Entrar al proyecto

```bash
cd daw2-practica-und1
```

## Crear su rama

```bash
git checkout -b practica/nombre-completo
```

## Verificar rama

```bash
git branch
```

## Ver cambios

```bash
git status
```

## Preparar cambios

```bash
git add .
```

## Crear commit

```bash
git commit -m "Resolver practica Unidad I"
```

## Subir la rama por primera vez

```bash
git push -u origin practica/nombre-completo
```

## Subir correcciones posteriores

```bash
git push
```

---

# FLUJO COMPLETO DE ENTREGA

```text
1. FORK
       ↓
2. CLONE
       ↓
3. CREAR RAMA
   practica/nombre-completo
       ↓
4. DESARROLLAR LA VARIANTE ASIGNADA
       ↓
5. PROBAR LA APLICACIÓN
       ↓
6. git status
       ↓
7. git add .
       ↓
8. git commit
       ↓
9. git push
       ↓
10. CREAR PULL REQUEST
       ↓
11. GITHUB ACTIONS
       ↓
12. COPIAR URL DEL PR
       ↓
13. PEGAR URL EN MOODLE
```

---

# IMPORTANTE

- La práctica es individual.
- Trabaje únicamente en su propia rama.
- Resuelva solamente la variante asignada.
- No modifique los archivos protegidos.
- Realice pruebas antes de enviar.
- No cree más de un Pull Request.
- Las correcciones posteriores se realizan mediante nuevos commits y `git push`.
- El enlace enviado en Moodle debe corresponder al **Pull Request hacia el repositorio original del docente**.
