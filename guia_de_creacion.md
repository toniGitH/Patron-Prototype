# 🧭 Guía de creación: paso a paso de la construcción del proyecto Patrón Prototype

Este documento detalla un **orden lógico** en el que se deben crear los archivos del proyecto y la razón de ser de cada uno.

No solo se explica el código, sino el **porqué** de cada decisión arquitectónica.

Aunque **la clonación es una operación nativa de PHP**, y por tanto, toda la estructura propuesta en este proyecto no es necesaria, se ha decidido implementar íntegramente el patrón para mostrar su estructura más allá del propio lenguaje de programación que se utilice.

---

## 1. `PrototypeInterface.php`: el corazón del patrón
*   **Ubicación**: `src/Domain/Contracts/`
*   **Qué es**: es la pieza central y el fundamento inicial de todo el proyecto. Es una **Role Interface** (Interfaz de Capacidad).
*   **Propósito**: define el contrato sagrado del patrón. Cualquier objeto que implemente esta interfaz está declarando formalmente al sistema: *"Yo soy un Prototipo, puedes clonarme con seguridad"*.
Esta interfaz nos obliga a implementar el método mágico `__clone()` para asegurar que el clonado sea profundo y no superficial.
*   **Detalle técnico**: 
    - contiene el método mágico `__clone()`, que es el mecanismo nativo de PHP para intervenir en el proceso de copiado (vital para asegurar que no compartamos referencias internas).
    - contiene `getInfo()`, que permite que cualquier clon se presente ante el mundo de forma estandarizada sin que sepamos exactamente qué tipo de objeto es.

## 2. `Author.php`: clase secundaria para entender la clonación profunda
*   **Ubicación**: `src/Domain/ValueObjects/`
*   **Qué es**: un **Value Object** (Objeto de Valor).
*   **Propósito**: representa una entidad sencilla (un autor) que será "inyectada" dentro de nuestros documentos. 
*   **Razón del orden de creación**: lo creamos antes que los documentos porque los documentos dependen de él. No es necesario en el patrón en sí, pero en este ejemplo sí lo es para demostrar la importancia del patrón: la **clonación profunda**. Sin él, el ejemplo sería demasiado simple y no veríamos el riesgo de compartir objetos en memoria (clonación superficial).

## 3. `TextDocument.php` y `Spreadsheet.php`: clases padre (abstractas) de productos genéricos
*   **Ubicación**: `src/Domain/ODT/` y `src/Domain/ODS/`
*   **Qué son**: clases abstractas.
*   **Propósito**: representan las dos grandes familias de documentos de la aplicación. Son abstractas porque no tiene sentido crear un "documento de texto" o un "documento de hoja de cálculo" genérico; siempre será una carta, un informe, etc.
Sin embargo, aunque no se instancien, sí que contienen todas las propiedades y métodos que cualquier objeto concreto de estas dos familias tiene que tener, tanto específicos de cada familia, como comunes a todas ellas impuestas por la interfaz (como la capacidad de clonarse).
Es decir, que estas dos clases **IMPONEN** los requisitos **OBLIGATORIOS** que debe cumplir CUALQUIER objeto de tipo documento de texto Y CUALQUIER objeto de tipo documento de hoja de cálculo (ya sea prototipo o producto concreto).
En cierto modo, también es una especie de contrato que implica que cualquier objeto creado a partir de estas clases (de sus clases hijas) tenga, por ejemplo, un título, un autor y la capacidad de clonarse (características comunes heredadas).
*   **Responsabilidad**: aquí es donde implementamos la interfaz `PrototypeInterface`. Definimos propiedades comunes (título, autor, tipo) y, lo más importante, programamos aquí la lógica de `__clone()` para que todos sus futuros hijos hereden la capacidad de clonarse profundamente de forma automática.

## 4. `Letter.php`, `Report.php`, `Budget.php`, `StaffPlanning.php`: los Prototipos y los Productos concretos
*   **Ubicación**: `src/Domain/ODT/` y `src/Domain/ODS/`
*   **Qué son**: clases finales y específicas.
*   **Propósito**: representan, al mismo tiempo:
    - los **prototipos**: son los moldes de cada tipo de documento concreto (letter, report, budget, staffPlanning). El fundamento de este patrón es que se creará (instanciará con *new*) uno y solo uno de cada uno de estos prototipos, cada uno de los cuales servirá como modelo para ser clonado y generar tantos productos concretos como se necesiten
    - los **productos concretos**: son los objetos reales que el usuario clonará.
En estas clases se añaden datos específicos de cada tipo concreto (destinatario, importe, número de empleados).
Tanto prototipos como productos concretos son instancias, salvo que los primeros son instanciados mediante *new* y los segundos mediante el operador *clone*.
Y esta es la característica nuclear de este patrón: no los objetos en sí (puesto que todos son instancias normales), sino la manera en la que se crean unos y otros.
*   **Escalabilidad**: si mañana necesitamos nuevos tipos de documento de estas familias, como por ejemplo "Invoice", "Memorandum", "Curriculum", etc... solo tendríamos que crear una nueva clase aquí, por ejemplo, Invoice.php, que debería heredar de la clase padre correspondiente, por ejemplo, Spreadsheet.php.

## 5. `PrototypeRegistry.php`: el gestor genérico
*   **Ubicación**: `src/Infrastructure/`
*   **Qué es**: es lo que en este patrón se conoce como **Prototype Manager**.
*   **Propósito**: le proporciona a los gestores concretos (ODTManager y ODSManager) toda la lógica que deben conocer para gestionar los documentos en esta aplicación. Es decir, que esta clase sólo "escribe la receta", pero son las clases hijas las que la "ejecutan".
Concretamente, para poder gestionar los documentos en esta aplicación, los gestores concretos (ODTManager y ODSManager) deben conocer:
    - **Almacén de prototipos `$prototypes`**: aquí se guardan los **prototipos** instanciados (sólo los prototipos) de cada tipo de documento, para que estén accesibles para cuando la aplicación necesite crear productos concretos (clones) a partir de ellos.
    - **Registrar prototipos `registerPrototype()`**: método que recibe el nombre que se dará al prototipo (alias), el tipo concreto de documento prototipo (string) y los argumentos necesarios para instanciarlo. Con estos datos y una llamada al método abstracto `createPrototype()` se registra el prototipo en el almacén.
    - **Crear prototipos `createPrototype()`**: esta clase necesita los objetos prototipo concretos para poder registrarlos en el almacén, pero lo que no puede hacer es crear esos prototipos concretos, porque no conoce sus características concretas (son las clases hijas las que conocen esas características y pueden crear esos prototipos concretos). Por tanto, este método queda como abstracto y se delega su implementación a las clases hijas. Los hijos serán los responsables de crear estos objetos prototipo concretos (instanciarlos con *new*).
    - **Crear productos concretos a partir de un prototipo registrado `createFromPrototype()`**: este método proporciona la lógica común de clonación, que es común a todos los prototipos. Por tanto, este método queda como concreto.


## 6. `ODTManager.php` y `ODSManager.php`: los gestores especializados
*   **Ubicación**: `src/Client/`
*   **Qué son**: clases que heredan las capacidades del padre `PrototypeRegistry`.
*   **Propósito**: deben tener todas las capacidades necesarias para gestionar los productos (crear prototipos, almacenarlos, y crear productos concretos a partir de los prototipos).

Para ello, concretamente, deben:
    - conocer todas las capacidades que la clase padre `PrototypeRegistry` les proporciona (lo cual ya hacen, puesto que extienden la clase padre),
    - implementar obligatoriamente el método abstracto `createPrototype()`, que se encargará de instanciar los prototipos concretos. Ésta es una responsabilidad fundamental en el proceso de registro de prototipos (es un paso intermedio dentro del método `registerPrototype()` que proporciona la clase padre).

## 7. `verifier.php`: clase auxiliar para verificar la independencia de los prototipos
*   **Ubicación**: raíz del proyecto.
*   **Qué es**: una herramienta de verificación externa. No necesaria en el patrón.
*   **Propósito**: proporciona el método `verifyIndependence()` para demostrar con pruebas irrefutables (IDs de objeto) que el patrón está cumpliendo su promesa: generar objetos nuevos e independientes.

## 8. `main.php`: el punto de entrada de la aplicación
*   **Ubicación**: raíz del proyecto.
*   **Qué es**: el punto de entrada (Entry Point).
*   **Acción**: aquí se conecta todo. Se instancian los autores, se crean los prototipos maestros, se registran en los managers y se solicitan los clones para personalizarlos.
*   **Detalle profesional**: gracias al uso de `vendor/autoload.php` (estándar PSR-4), este archivo no necesita conocer las rutas de las clases. El sistema escala automáticamente: si añadimos 100 tipos nuevos, el `main.php` se mantiene limpio y sin `require` adicionales.
76: 
77: <br>
78: 
79: [Volver al Readme](README.md)
