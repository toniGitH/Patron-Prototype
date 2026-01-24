# Guía de Construcción: Paso a Paso del Proyecto Prototype

Este documento detalla el orden lógico y la razón de ser de cada componente creado en este proyecto. Aquí no solo se explica el código, sino el **porqué** de cada decisión arquitectónica.

---

### 1. El Corazón del Patrón: `PrototypeInterface.php`
*   **Ubicación**: `src/Domain/Contracts/`
*   **Qué es**: Es la pieza central y el fundamento inicial de todo el proyecto. Es una **Role Interface** (Interfaz de Capacidad).
*   **Propósito**: Define el contrato sagrado del patrón. Cualquier objeto que implemente esta interfaz está declarando formalmente al sistema: *"Yo soy un Prototipo, puedes clonarme con seguridad"*.
*   **Detalle técnico**: 
    - Contiene el método mágico `__clone()`, que es el mecanismo nativo de PHP para intervenir en el proceso de copiado (vital para asegurar que no compartamos referencias internas).
    - Contiene `getInfo()`, que permite que cualquier clon se presente ante el mundo de forma estandarizada sin que sepamos exactamente qué tipo de objeto es.

### 2. El Ingrediente de Apoyo: `Author.php`
*   **Ubicación**: `src/Domain/ValueObjects/`
*   **Qué es**: Un **Value Object** (Objeto de Valor).
*   **Propósito**: Representa una entidad sencilla (un autor) que será "inyectada" dentro de nuestros documentos. 
*   **Razón del orden**: Lo creamos antes que los documentos porque los documentos dependen de él. No es necesario en el patrón en sí, pero en este ejemplo sí lo es para demostrar la gran potencia del patrón: la **clonación profunda**. Sin él, el ejemplo sería demasiado simple y no veríamos el riesgo de compartir objetos en memoria.

### 3. Las Clases Padre (Bases del Dominio): `TextDocument.php` y `Spreadsheet.php`
*   **Ubicación**: `src/Domain/ODT/` y `src/Domain/ODS/`
*   **Qué son**: Clases abstractas.
*   **Propósito**: Representan las dos grandes familias de la aplicación. Son abstractas porque no tiene sentido crear un "documento de texto" genérico; siempre será una carta, un informe, etc. Sin embargo, aunque no se instancien, sí que contienen todas las propiedades y métodos que cualquier objeto concreto de estas familias tienen que tener, tanto particulares de cada familia, como las comunes impuestas por la interface.
Es decir, IMPONE los requisitos COMUNES Y OBIGATORIOS que debe cumplir CUALQUIER objeto de tipo documento de texto Y CUALQUIER objeto de tipo documento de hoja de cálculo (ya sea prototipo o producto concreto).
*   **Responsabilidad**: Aquí es donde implementamos de una vez por todas la `PrototypeInterface`. Definimos propiedades comunes (título, autor, tipo) y, lo más importante, programamos aquí la lógica de `__clone()` para que todos sus futuros hijos hereden la capacidad de clonarse profundamente de forma automática.

### 4. Los Prototipos/Productos Concretos: `Letter`, `Report`, `Budget`, `StaffPlanning`
*   **Ubicación**: Subcarpetas de `ODT` y `ODS`.
*   **Qué son**: Las clases finales y específicas.
*   **Propósito**: Representa, al mismo tiempo:
    - los prototipos: son los moldes de cada tipo de documento (spreadsheet y text document). El fundamento de este patrón es que se creará (instanciará con new) uno solo de cada uno de estos prototipos, los cuales se clonarán para generar los productos concretos que se necesiten
    - los productos concretos: son los objetos reales que el usuario clonará.
En estas clases se añaden datos específicos de cada tipo concreto (destinatario, importe, número de empleados).
*   **Relación con el patrón**: Su existencia permite que el sistema sea infinito: si mañana necesitamos "Facturas", solo crearíamos un nuevo archivo aquí, por ejemplo, Invoice.php, que debería heredar de la clase padre correspondiente, por ejemplo, Spreadsheet.php.

### 5. El Cerebro de la Gestión: `PrototypeRegistry.php`
*   **Ubicación**: `src/Infrastructure/`
*   **Qué es**: El **Prototype Manager** (oficial en el libro de la GoF).
*   **Propósito**: Es el "almacén" o catálogo de prototipos. Evita que los prototipos estén sueltos por el código de forma desordenada.
*   **Razón de ser**: Es una clase de infraestructura porque maneja la técnica pura: tiene un array para guardar los prototipos y un método que usa el operador `clone` de PHP. Al ser abstracta, nos permite reutilizar esta lógica técnica en diferentes áreas del negocio sin repetir código.

### 6. Los Gestores Especializados: `ODTManager.php` y `ODSManager.php`
*   **Ubicación**: `src/Client/`
*   **Qué son**: Clientes o Gestores especializados.
*   **Propósito**: Actúan como servicios que el resto de la aplicación usará. El `ODTManager` sabe que solo debe manejar documentos de texto, y el `ODSManager` hojas de cálculo.
*   **Innovación técnica**: Implementan el método `registerFromType()`. Esto permite que el cliente ya no tenga que usar el operador `new` directamente, delegando la responsabilidad de la instanciación inicial al propio gestor a través de un simple nombre (string) y un array de argumentos.
*   **Arquitectura**: Extienden del Registro para heredar la tecnología de clonación, pero su nombre le da sentido semántico al proyecto.

### 7. El Juez Independiente: `verifier.php`
*   **Ubicación**: Raíz del proyecto.
*   **Qué es**: Una herramienta de verificación externa.
*   **Propósito**: Proporciona el método `verifyIndependence()` para mirar "bajo el capó" de la memoria RAM. 
*   **Razón**: No es parte del patrón Prototype, pero es la única forma de demostrar con pruebas irrefutables (IDs de objeto) que el patrón está cumpliendo su promesa: generar objetos nuevos e independientes.

### 8. El Director de Orquesta: `main.php`
*   **Ubicación**: Raíz del proyecto.
*   **Qué es**: El punto de entrada (Entry Point).
*   **Acción**: Aquí se conecta todo. Se instancian los autores, se crean los prototipos maestros, se registran en los managers y se solicitan los clones para personalizarlos.
*   **Culminación**: Es donde el patrón Prototype cobra vida y demuestra que podemos crear sistemas multidominio, escalables y eficientes.
