<a name="top"></a>

# 🤖🤖🤖 El patrón Prototype - Guía Completa

Repositorio creado para explicar el patrón **Prototype** y su implementación mediante un ejemplo práctico en **PHP** (Gestor de documentos).

<br>

## 📖 Tabla de contenidos

<details>
  <summary>Mostrar contenidos</summary>
  <br>
  <ul>
    <li>🤖 <a href="#-el-patrón-prototype">El patrón Prototype</a>
      <ul>
        <li>💡 <a href="#-entendiendo-la-definición">Entendiendo la definición</a></li>
        <li>🛂 <a href="#-elementos-típicos-que-encontramos-en-un-patrón-prototype">Elementos típicos que encontramos en un patrón Prototype</a></li>
        <li>✅ <a href="#-aplicando-la-definición-a-un-caso-práctico-gestor-de-documentos">Aplicando la definición a un caso práctico: Gestor de documentos</a></li>
        <li>👍🏼 <a href="#-cuándo-usar-el-patrón-prototype">¿Cuándo usar el patrón Prototype?</a></li>
        <li>🎯 <a href="#-qué-beneficios-se-obtienen-al-aplicar-el-patrón-prototype"> ¿Qué beneficios se obtienen al aplicar el patrón Prototype?</a></li>
      </ul>
    </li>
    <li>🧪 <a href="#-ejemplo-de-implementación-gestor-de-documentos">Ejemplo de implementación: Gestor de documentos</a>
      <ul>
        <li>🎡 <a href="#-qué-hace-esta-aplicación-de-ejemplo">¿Qué hace esta aplicación de ejemplo?</a></li>
        <li>🔄 <a href="#-flujo-completo-de-esta-aplicación-de-ejemplo">Flujo completo de esta aplicación de ejemplo</a></li>
        <li>👉🏼 <a href="#-identificación-de-los-principales-archivos-del-ejemplo">Identificación de los principales archivos del ejemplo</a></li>
        <li>🧭 <a href="#-guía-de-creación-del-proyecto">Guía de creación del proyecto</a></li>
      </ul>
    </li>
    <li>📂 <a href="#-estructura-del-proyecto-y-composer">Estructura del Proyecto y Composer</a></li>
    <li>📋 <a href="#-requisitos">Requisitos</a></li>
    <li>🚀 <a href="#-instalación-y-ejecución">Instalación y Ejecución</a></li>
  </ul>
</details>

---

<br>

## 🤖 El patrón Prototype

> ⚠️ **ACLARACIÓN PREVIA**
>
> En el lenguaje PHP, la clonación de objetos es una funcionalidad nativa, gracias al operador **clone** y al método mágico **__clone()** que se ejecuta automáticamente tras aplicar el operador **clone**.
>
> Eso significa que esta funcionalidad práctica se podría obtener sin necesidad de aplicar este patrón en su forma más pura o canónica.
>
> Sin embargo, para tratar de entender la arquitectura que hay en este patrón más allá del lenguaje utilizado, he decidido "complicar" el ejemplo, implementando el patrón en su forma más pura.
>
> Para entender mejor cómo he implementado el patrón Prototype en este proyecto, te recomiendo que leas el archivo [clonacion_en_php.md](clonacion_en_php.md) que se encuentra en la raíz del proyecto.

El patrón **Prototype** es un patrón **creacional** que trata de evitar la creación de objetos complejos a partir de cero, con el coste de recursos que ello podría implicar en determinados casos, proponiendo una estructura que permita crear copias de objetos ya existentes en lugar de crearlos desde cero.

Este patrón propone la creación de una **interface** o contrato que define algún **método de clonación** que deberá ser **implementado por todas aquellas clases que quieran ser clonadas**. Esta interfaz no sólo se identifica con clonación, sino también con el **concepto de prototipo**, de forma que **las clases que lo implementen** quedan automáticamente "identificadas" como **clases creadoras de prototipos clonables**, y por tanto, los objetos creados a partir de estas clases, podrán ser utilizadas como **prototipos** para ser clonados, pero también, no lo olvidemos, como **productos concretos finales** (obtenidos a partir de la clonación de dichos prototipos).

**Opcionalmente**, estas clases que representan productos clonables podrían perder su identidad de clases concretas y convertirse en **clases padre abstractas**, agrupando varias **clases que representen objetos del mismo tipo**, para aquellos casos en los que esos objetos, aún siendo del mismo tipo, presenten una estructura de datos (propiedades y métodos) diferente. Por ejemplo, una carta y un informe son objetos de tipo `TextDocument`, con propiedades y métodos comunes, pero también con alguna propiedad o método específico de cada uno.

En caso de que lo que tengamos es un mismo objeto que puede tener diferentes configuraciones, es decir, varios objetos, todos ellos con las mismas propiedades, pero con valores distintos entre ellos, no debemos crear subclases para cada uno de dichos objetos, sino que precisamente, debemos aprovechar las posibilidades que nos brinda este patrón y crear un prototipo para cada una de las configuraciones posibles.

Y si la situación lo requiere, también es posible implementar lo que en el patrón se conoce como **registro de prototipos**, que permite almacenar y recuperar prototipos clonables de forma centralizada, lo que facilita su reutilización y mejora la eficiencia del código.

En casos más complejos, dicho **registro de prototipos** también puede perder su identidad de clase concreta y convertirse en una **clase padre abstracta** que agrupe varios **registros de prototipos**.

<br>

### 💡 Entendiendo la definición

Lo primero a tener en cuenta para entender lo que significa este patrón es que **crear un nuevo objeto**, en muchos casos, puede suponer un **coste de recursos** (memoria, tiempo de procesamiento, etc...).

Esto puede ser especialmente problemático cuando se requieren **crear muchos objetos de un mismo tipo**, ya que cada uno de ellos requiere su propia creación, lo que puede resultar en un consumo excesivo de recursos.

La creación de un objeto desde cero frente a la **clonación** de un objeto ya existente **puede suponer un ahorro considerable de dichos recursos**, por lo que este patrón pretende crear una estructura que permita **crear copias** de objetos ya existentes, llamados **prototipos** en lugar de crearlos desde cero.

El patrón **Prototype** propone la creación de una **PrototypeInterface**, en la que se declarará algún método de clonación que, al ser implementado por ciertas clases:
- las convierte en **clases creadoras de prototipos** y **productos concretos**
- les proporciona un **método de clonación interno**, de manera que dicha clonación pueda ejecutarse aún cuando dichos objetos tengan **propiedades privadas no accesibles desde fuera** (la clonación se realizaría desde dentro del propio objeto)

Una vez implementado este patrón, cada vez que se necesite **crear muchos objetos del mismo tipo**, se creará **desde cero sólo un primer prototipo**, a partir del cual se crearán el **resto de objetos del mismo tipo a partir de la clonación del prototipo**.

La implementación de **registro de prototipos** y de **clases abstractas padre de prototipos** queda como **opcional** en este patrón, en función de la complejidad del proyecto.

En el ejemplo que se muestra a continuación, a pesar de su simplicidad y de que no sería estrictamente necesario, por razones didácticas se ha implementado el patrón de forma completa, es decir, incluyendo la implementación de **registro de prototipos** y de **clases abstractas padre de prototipos**.


### 🧩 Elementos típicos que encontramos en un patrón Prototype

1️⃣  **PrototypeInterface**: es la interfaz que declara el método de clonación que debe ser implementado por todas las clases que quieran ser clonadas.

**Dependiendo del lenguaje**, este método de clonación puede ser un método `clone()`, un método   `__clone()` o incluso puede ser que la propia implementación del patrón sea innecesaria, como en el caso de PHP, que de forma nativa ya dispone del operador `clone` y del método mágico `__clone()`.

2️⃣ **Clases creadoras de prototipos clonables concretos**: estas clases implementan la **PrototypeInterface** y proporcionan la implementación concreta del método de clonación. Estas clases representan tanto los **prototipos** iniciales de partida como los **productos concretos** finales obtenidos a partir de la clonación de dichos prototipos.

3️⃣ **Clases abstractas padre de prototipos clonables concretos**: estas clases son **opcionales** y se crean cuando el proyecto debe manejar múltiples tipos de objetos con múltiples propiedades y variaciones de las mismas.

4️⃣ **Prototipo**: es un **objeto que se clona para crear copias de sí mismo**. El prototipo **se crea desde cero**, con todo el coste de recursos que esto pueda suponer, pero **sólo se crea una vez**, y sirve como base o plantilla para ser clonado y **obtener copias exactas de sí mismo** (es más fácil clonar que crear desde cero), que pueden ser **modificadas posteriormente** para obtener diferentes productos concretos.

5️⃣ **Productos concretos**: son los **objetos finales obtenidos a partir de la clonación de los prototipos**. Estos productos concretos pueden ser modificados para obtener diferentes productos concretos.

6️⃣ **Registro de prototipos**: es una clase que **almacena y recupera prototipos clonables de forma centralizada**, lo que facilita su reutilización y mejora la eficiencia del código.

7️⃣ **Registro de prototipos específicos**: cuando el proyecto tenga que manejar múltiples tipos de objetos con múltiples propiedades y variaciones de las mismas, puede ser interesante convertir (opcionalmente) el anterior registro de prototipos en una **clase abstracta** que marque las reglas generales de registro de prototipos, de la cual **extiendan clases concretas**, cada una encargada de la gestión de un tipo concreto de prototipos.

> ℹ️ **ACLARACIÓN**: tanto un **prototipo** como un **producto concreto** son **instancias**, sin ninguna diferencia sustancial entre ellas (salvo los valores concretos de sus propiedades), pero lo que cambia en ellas sólo es la forma en la que han sido creadas.

<br>

### ✅ Aplicando la definición a un caso práctico: Gestor de documentos

Podemos aplicar este patrón a la creación de un gestor de documentos.

Imagina que queremos poder trabajar con documentos de tipo texto (ODT), y con documentos de tipo hoja de cálculo (ODS).

Es normal pensar que en este tipo de aplicación vamos a crear multitud de documentos (objetos) a lo largo del tiempo, por lo que no sería eficiente crear cada documento desde cero.

Gracias al patrón, lo que haremos será crear un primer prototipo de documento de tipo texto (ODT) y un primer prototipo de documento de tipo hoja de cálculo (ODS), y a partir de ellos, clonarlos para crear nuevos documentos.

#### LA INTERFAZ PROTOTIPO

Para ello, tenemos que crear, en primer lugar, una **interfaz** `PrototypeInterface` que defina los métodos necesarios para que un objeto pueda clonarse a sí mismo.

#### LAS CLASES Y SUBCLASES CREADORAS DE PROTOTIPOS Y PRODUCTOS

Vamos a suponer, también, que dentro de los documentos de tipo texto, podemos encontrar cartas, informes, etc..., cada uno de ellos con sus propias propiedades y variaciones. Y de igual manera, con los documentos de tipo hoja de cálculo (ODS), podemos encontrar facturas, planificaciones de personal, etc..., cada uno de ellos con sus propias propiedades y variaciones.

Aunque podríamos crear una **clase concreta** para cada tipo de documento concreto (carta, informe, presupuesto, etc...), sería más eficiente crear una **clase abstracta** para cada tipo genérico de documento (texto y hoja de cálculo), de la cual extiendan las clases concretas.

Por ejemplo, una clase abstracta para documentos de tipo texto (ODT), llamada `TextDocument`, y a partir de ella, crear las clases concretas de cartas (`Letter`) e informes (`Report`). Y de igual manera, una **clase abstracta** para documentos de tipo hoja de cálculo (ODS), llamada `Spreadsheet`, y a partir de ella, crear las clases concretas de presupuestos (`Budget`) y planificaciones de personal (`StaffPlanning`).

La gran ventaja de hacerlo así es que tendremos **la lógica común** a todos los documentos de tipo texto en la clase `TextDocument`, y la lógica (propiedades y métodos) común a todos los documentos de tipo hoja de cálculo en la clase `Spreadsheet`, y sólo la tendremos que **escribir una vez**, mientras que en las clases hijas no tendremos que escribir esa lógica común, puesto que la heredarán, y solamente nos preocuparemos por implementar lógica específica (propiedades y métodos específicos) para cada clase.

Tal y como se mencionaba en la definición del patrón un poco más arriba, la solución de crear subclases sólo se debe implementar para este tipo de casos (objetos del mismo tipo con diferentes estructuras de datos), puesto que si lo que tenemos es, por ejemplo, una carta `Letter` que puede tener diferentes configuraciones, como por ejemplo, carta formal, carta informal, carta estándar, no necesitaríamos subclases de la clase `Letter`, sino que bastaría con generar los prototipos correspondientes.

En el caso del ejemplo, en el main.php, podríamos crear diferentes prototipos de cartas a partir de la misma clase haciendo esto:

```
$odtManager->registerPrototype("std_letter_prototype", "Letter", ["Standard Letter", $systemAuthor, "Guest"]);
$odtManager->registerPrototype("formal_letter_prototype", "Letter", ["Formal Letter", $systemAuthor, "Guest"]);
$odtManager->registerPrototype("informal_letter_prototype", "Letter", ["Informal Letter", $systemAuthor, "Guest"]);
```

#### ESCALABILIDAD

Si en el futuro queremos, por ejemplo, **incorporar nuevos tipos de documentos concretos** de tipo texto, como por ejemplo un `CV`, simplemente tendremos que crear una nueva clase `CV` que extienda de `TextDocument` y añadirle las propiedades y métodos específicos que necesitemos. No tendremos que modificar ninguna de las clases existentes. Y en caso de que hubiéramos decidido usar un registro de prototipos, tampoco tendríamos que modificarlo (ni la clase abstracta `PrototypeRegistry` ni la clase concreta `ODTManager`).

De igual forma, podríamos querer ampliar la aplicación incluyendo otro tipo de documentos que no fueran de texto u hojas de cálculo, como por ejemplo, documentos de tipo presentación (ODP), en cuyo caso, simplemente tendríamos que crear una nueva clase abstracta `Presentation` que implementara la interfaz `PrototypeInterface` y a partir de ella, crear las clases concretas de presentaciones que necesitáramos (por ejemplo, una presentación para una reunión, una presentación para una conferencia, etc...). En este caso, tampoco tendríamos que modificar, si hubiéramos decidido implementarlo, el `PrototypeRegistry`, aunque si quisiéramos usar un manager concreto, sí deberíamos crear un `ODPManager`.

#### EL REGISTRO DE PROTOTIPOS

Como además, queremos una **implementación ordenada y organizada**, vamos a crear un **registro de prototipos** para almacenar y recuperar prototipos clonables de forma centralizada, lo que facilitará su reutilización y mejorará la eficiencia del código.

Pero como es posible que la gestión de documentos de tipo texto varíe respecto de la gestión de documentos de tipo hoja de cálculo, aplicaremos el mismo principio anterior, y crearemos una **clase abstracta** `PrototypeRegistry` que **encapsulará toda la lógica común a la gestión de prototipos**, y serán sus hijas, `ODSManager` y `ODTManager` las que heredarán esa lógica común e implementarán la lógica específica de cada tipo de gestor de documentos.

A nivel conceptual y por razones meramente didácticas, se ha considerado en este ejemplo que estos dos gestores concretos, `ODSManager` y `ODTManager`, son los clientes que van a "consumir" el patrón Prototype (aunque al mismo tiempo forman parte de él).

<br>

### 👍🏼 ¿Cuándo usar el patrón Prototype?

Este patrón suele utilizarse en situaciones en las que determinados **objetos complejos de un mismo tipo son utilizados con mucha frecuencia**, por lo que **en lugar de crearlos desde cero, se clonan desde un prototipo**.

<br>

### 🎯 ¿Qué beneficios se obtienen al aplicar el patrón Prototype?

📌 **Ahorro de recursos en la creación de objetos**: cuando hablamos de objetos complejos, normalmente la clonación de un objeto consume menos recursos que la creación de un objeto desde cero.

📌 **Reutilización de código**: la utilización de subclases para determinados casos (objetos del mismo tipo con estructuras diferentes) y la creación de registros de prototipos concretos (cuando dicha gestión varía en función del tipo de objetos), nos permite encapsular la lógica común en clases abstractas y reutilizarla en sus hijas.

📌 **Desacoplamiento del código**: este patrón hace que el código cliente sea independiente de las clases concretas de los objetos que clona. En este ejemplo, tenemos un gestor de documentos de texto `ODTManager`, que permite gestionar documentos de diferentes tipos sin necesidad de conocer la implementación de cada uno de ellos, pudiendo incluir en el futuro nuevos documentos de ese tipo sin tocar una sola línea de código del `ODTManager`.

<br>

[🔝](#top)

---

<br>

## 🧪 Ejemplo de implementación: Gestor de documentos

### 🎡 ¿Qué hace esta aplicación de ejemplo?

En este ejemplo, vamos a crear un gestor de documentos que permita gestionar documentos de diferentes tipos (texto y hoja de cálculo) de forma centralizada, utilizando el patrón Prototype para clonar documentos existentes y crear nuevos documentos con la misma estructura.

Dado que dentro de los documentos de texto podemos encontrarnos con documentos con propiedades diferentes, como puede ser una carta frente a un informe, vamos a crear las subclases necesarias que representen a estos tipos de documentos de texto, y haremos lo mismo con los documentos de tipo hoja de cálculo.

Además, se mostrará también la manera de implementar el registro de prototipos, suponiendo que cada familia de documentos (texto y hoja de cálculo) se gestiona de manera diferente, por lo que crearemos dos subclases de registro de prototipos, una para cada familia de documentos.

### 🔄 Flujo completo de esta aplicación de ejemplo

El flujo de la aplicación se divide en dos grandes apartados:

1. Creación de diferentes tipos de documentos, cada uno de los cuales sigue siempre el mismo flujo:

    1.1. Inicializar el gestor
    1.2. Registrar el prototipo
    1.3. Clonar el prototipo
    1.4. Modificar el prototipo => obtenemos un documento concreto
    1.5. Usar el documento concreto

2. Verificación de independencia total (triple comparativa):

    2.1. Crear un segundo documento concreto
    2.2. Comparar el prototipo con el primer documento concreto
    2.3. Comparar el prototipo con el segundo documento concreto
    2.4. Comparar el primer documento concreto con el segundo documento concreto

### 👉🏼 Identificación de los principales archivos del ejemplo

#### ➡️ Interfaz de prototipo `PrototypeInterface`
Ubicado en `src/Domain/Contracts`:
- `PrototypeInterface.php`

#### ➡️ Clases y subclases de prototipos
Ubicadas en `src/Domain/ODS`:
- `Spreadsheet.php` - clase abstracta para documentos de tipo ODS
- `Budget.php` - subclase de prototipo de documento de tipo hoja de cálculo
- `StaffPlanning.php` - subclase de prototipo de documento de tipo hoja de cálculo
y en `src/Domain/ODT`:
- `TextDocument.php` - clase abstracta para documentos de tipo ODT
- `Letter.php` - subclase de prototipo de documento de tipo texto
- `Report.php` - subclase de prototipo de documento de tipo texto

#### ➡️ Objetos anidados
Ubicado en `src/Domain/ValueObjects`:
- `Author.php`

#### ➡️ Registro de prototipos (abstracto)
Ubicado en `src/Infrastructure`:
- `PrototypeRegistry.php` - clase abstracta

#### ➡️ Registros de prototipos concretos (gestores de documentos concretos)
Ubicados en `src/Client`:
- `ODTManager.php` - gestor de documentos de tipo ODT
- `ODSManager.php` - gestor de documentos de tipo ODS

#### ➡️ Lógica de verificación
Ubicada en `src/verifier.php`

#### ➡️ Flujo de ejecución de la aplicación
Ubicada en `src/main.php`

#### ➡️ Visualización de resultados
Ubicadas en `src/index.php` y en `src/styles.css`

### 🧭 Guía de creación del proyecto

En el archivo [guia_de_creacion.md](guia_de_creacion.md) se explican los pasos que se han seguido para escribir el proyecto en un orden lógico.

<br>

[🔝](#top)

---

<br>

## 📂 Estructura del Proyecto y Composer

A diferencia de ejemplos más simples donde todos los archivos están en la raíz, aquí hemos dado un paso avanzado hacia una estructura profesional de PHP moderna.

### 1. Organización del código en `src/`

Para mantener el orden hemos movido todo el código fuente a la carpeta `src/`.

### 2. Autocarga con Composer (PSR-4)

En lugar de tener una lista interminable de `require_once "archivo.php"` en nuestro `main.php`, utilizamos **Composer** para la carga automática de clases.

El archivo `composer.json` define el mapeo:
```json
"autoload": {
    "psr-4": {
        "App\\": "src/"
    }
}
```
Esto significa que cualquier clase con el namespace que empiece por `App\` será buscada automáticamente por PHP dentro de la carpeta `src/`. Por ejemplo, la clase `App\Domain\ODS\Budget.php` se buscará en `src/Domain/ODS/Budget.php`.

Gracias a esto, en nuestro `main.php` solo necesitamos una línea para cargar TODO el proyecto:
```php
require "vendor/autoload.php";
```

<br>

[🔝](#top)

---

<br>

## 📋 Requisitos

- **PHP 8.0** o superior.
- **[Composer](https://getcomposer.org/)**: Necesario para generar el mapa de clases (autoload).

<br>

## 🚀 Instalación y Ejecución

### 1. Instalación

1.  Clona este repositorio o descarga los archivos.
2.  Abre una terminal en la carpeta raíz del proyecto.
3.  Ejecuta el siguiente comando para generar la carpeta `vendor` y el autoloader:

    ```bash
    composer dump-autoload
    ```
    > 💡 **Nota**: Como este proyecto no tiene dependencias de librerías externas (solo usamos Composer para el autoload), basta con `composer dump-autoload`. Si hubiera librerías en `require`, usaríamos `composer install`.

### 2. Ejecución

Tienes dos alternativas para visualizar el resultado de la aplicación:
- visualizando los resultados mediante el **navegador** (con XAMPP o con un servidor web local).
- directamente desde la **terminal**, en texto plano, ejecutando el archivo principal, `main.php`.

#### 🖥️ Para ejecutarlo mediante la Terminal:

1. Abre la terminal y navega a la carpeta de tu proyecto, por ejemplo:

```bash
cd ~/Documentos/Proyectos/patrones/prototype
```

2. Ejecuta, desde esa ubicación, el archivo main.php:

```bash
php main.php
```

#### 🌐 Para ejecutarlo mediante XAMPP:

1. Mueve la carpeta del proyecto a la carpeta htdocs (o equivalente según la versión de XAMPP y sistema operativo que uses).
2. Arranca XAMPP.
3. Accede a index.php desde tu navegador (por ejemplo: http://localhost/patrones/prototype/index.php)

#### 🌐 Para ejecutarlo usando el servidor web interno de PHP

PHP trae un servidor web ligero que sirve para desarrollo. No necesitas instalar Apache ni XAMPP.

1. Abre la terminal y navega a la carpeta de tu proyecto:

```bash
cd ~/Documentos/.../patrones/prototype
```
2. Dentro de esa ubicación, ejecuta:

```bash
php -S localhost:8000
```

>💡 No es obligatorio usar el puerto 8000, puedes usar el que desees, por ejemplo, el 8001.

Con esto, lo que estás haciendo es crear un servidor web php (cuya carpeta raíz es la carpeta seleccionada), que está escuchando en el puerto 8000 (o en el que hayas elegido).

>💡 Si quisieras, podrías crear simultáneamente tantos servidores como proyectos tengas en tu ordenador, siempre y cuando cada uno estuviera escuchando en un puerto diferente (8001, 8002, ...).

3. Ahora, abre tu navegador y accede a http://localhost:8000

Ya podrás visualizar el documento index.php con toda la información del ejemplo.

>💡 No es necesario indicar `http://localhost:8000/index.php` porque el servidor va a buscar dentro de la carpeta raíz (en este caso, en Documentos/.../patrones/prototype), un archivo index.php o index.html de forma automática. Si existe, lo sirve como página principal.
>
> Por eso, estas dos URLs funcionan igual:
>
> http://localhost:8000
>
> http://localhost:8000/index.php


<br>

[🔝](#top)