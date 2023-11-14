<h1> Primer endpoint: </h1>

('productos','GET','ProductosAPIController','getProductos');

Este endpoint sirve tanto para obtener todos los productos de la base de datos, y también para ordenarlos por todas las columnas de la tabla, ya sea de forma ascendente o descendente.
Para pedir los datos sin más, hay que usar la siguiente dirección en Postman con el verbo GET:

ruta_serividor_apache/api/productos

Y para ordenarlos como uno quiera, sería de la siguiente forma:

ruta_serividor_apache/api/productos?sort=(columna_de_la_tabla)&order=(ASC || DESC)

Sort indica por qué columna de la tabla se ordenan, y order si lo hacen de forma ascendente o descendente

<h1> Segundo endpoint: </h1>

('productos/:ID','GET','ProductosAPIController','getProductosID');

Este endpoint sirve para agarrar un único producto de la base de datos usando su id.
Se usa con el verbo GET de la siguiente forma:

ruta_serividor_apache/api/productos/(ID)

ID tiene que ser el id de uno de los productos en la base de datos

<h1> Tercer endpoint: </h1>

('addProducto','POST','ProductosAPIController','addProducto');

Este endpoint sirve para añadir un  producto a la base de datos pasandole todos los datos como un JSON para completar todas las columnas de una fila, menos el id, que es auto-incremental
Se usa con el verbo POST de la siguiente forma:

ruta_serividor_apache/api/addProducto

Y en Postman hace falta pasarle un objeto JSON por el body, como este:

```json
  {
    "nombre": "Nombre del producto",
    "descripcion": "Descripción del producto",
    "precio": "Precio del producto",
    "id_genero": "Id de la categoria a la que pertenece el producto"
  }
```

<h1> Cuarto endpoint: </h1>

('updateProducto/:ID','PUT','ProductosAPIController','updateProducto');

Este endpoint sirve para editar un producto de la base de datos, este producto se selecciona con su id.
Se usa con el verbo PUT de la siguiente forma:

ruta_serividor_apache/api/productos/(ID)

ID tiene que ser el id de uno de los productos en la base de datos, y los datos que se van a editar van a ser los del producto con ese id.
También se necesita tener un JSON en el body de Postman, como con el endpoint anterior:

```json
  {
    "nombre": "Nombre del producto",
    "descripcion": "Descripción del producto",
    "precio": "Precio del producto",
    "id_genero": "Id de la categoria a la que pertenece el producto"
  }
```
