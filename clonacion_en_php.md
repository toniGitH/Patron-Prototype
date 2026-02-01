# 🤖🤖 La clonación en PHP

Para entender mejor cómo se ha aplicado el patrón Prototype en este proyecto, puesto que está construido con el lenguaje PHP, recomiendo primero entender cómo funciona el proceso de clonación en PHP.

---

## ¿Cómo funciona la clonación en PHP?

Un objeto en PHP puede tener diferentes propiedades, y éstas pueden ser de diferentes tipos:

- valores primitivos o escalares (int, string, bool, etc...),
- objetos,
- arrays, que pueden contener valores escalares o primitivos y también objetos

**El operador `clone`**

En el proceso de clonación, por un lado existe un operador llamado `clone`, que **no es un método de PHP, sino un operador** (como +, -, *, /, etc...), pero que realiza una operación algo más compleja que un simple operador: es capaz de copiar un objeto con todas sus propiedades, siempre que dichas propiedades sean valores primitivos o escalares y arrays de valores primitivos o escalares.

No es capaz de copiar como tal propiedades que sean objetos, ni objetos que contengan una propiedad que sea un array. O mejor dicho, sí que copia la propiedad en sí, pero su valor, en este caso, ese objeto, no es un verdadero duplicado independiente, sino una referencia al objeto original, con lo que si modificamos el objeto original, también se modificará el objeto clonado, y viceversa.

A este tipo de clonado se le llama *shallow copy*, es decir, que copia el objeto con todas sus propiedades, pero que en el caso de esas propiedades que son objetos, no son verdaderamente objetos independientes de los originales, sino que mantienen la referencia al objeto original.

**El método mágico `__clone()`**

Por otro lado existe el método `__clone()`, que sí es un **método**, concretamente es un **método mágico nativo de PHP** que **se ejecuta automáticamente** cuando utilizamos el operador `clone`, y que por defecto está **vacío**, es decir, no tiene implementación.

Este método `__clone()` está diseñado como vacío, y su propósito es que pueda ser reescrito dentro de una determinada clase, conteniendo instrucciones para copiar sus propiedades que sean objetos.

Es decir, que dado que el operador `clone` no hace una verdadera copia de aquellas propiedades que sean objetos, PHP nos proporciona un método "autoejecutable" o **hook** (que se ejecuta al usar el operador `clone`), para que incluyamos dentro de él todas aquellas instrucciones que consideremos oportunas para que estas propiedades objetos sí se clonen realmente (como valores independientes respecto de los del objeto original).

A este tipo de clonado, en el que se implementa el método `__clone()` para copiar también las propiedades que sean objetos, se le llama *deep copy*.

Por tanto, podríamos decir que el proceso de clonación se divide en dos fases: "shallow copy" y "deep copy".

**El proceso de clonación**

Lo importante que hay que entender es que, en el proceso de clonación, tanto el operador `clone` como el método mágico **__clone** siempre **ACTÚAN EN CONJUNTO**.

Cuando llamamos al operador `clone`, durante el proceso de clonación que se inicia, se va a comprobar si el método **__clone** es **ACCESIBLE**:

- si el método `__clone()` existe y es *public*, el proceso de clonado se ejecutará sin problemas, ejecutándose la *shallow copy* más la *deep copy* (se copiarán las propiedades objeto que se hayan implementado en el método `__clone()`)
- si el método `__clone()` no existe, el proceso de clonado también se ejecutará sin problemas, pero sólo se ejecutará la *shallow copy* (no se copiarán las propiedades objeto puesto que el método `__clone()`, al no existir, no implementará la copia de las propiedades objeto)
- si el método `__clone()` existe pero es *private* o *protected*, el proceso de clonado fallará, y no se ejecutará ninguna de las fases.
44: 
45: <br>
46: 
47: [Volver al Readme](README.md)
