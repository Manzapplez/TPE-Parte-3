#  Trabajo Práctico Especial Web 2 | API Rest

### Grupo 80
Manzalini Abitante, Malena
> manzamale@gmail.com

***
Esta API nos permite listar, obtener, crear y editar canciones
## ENDPOINTS
| URL                       | VERBO         | CONTROLLER        | METODO        |  
| -----------               | ----------    | ------------      |------------   |
| `api/songs`               | GET           | ApiSongController | getSongs()    |
| `api/songs/:id`           | GET           | ApiSongController | getSong($id)  |
| `api/songs/`              | POST          | ApiSongController | addSong()     |
| `api/songs/:id`           | PUT           | ApiSongController | editSong($id) |


### GET /api/songs
Devuelve el listado de canciones, podemos ordenar, filtrar y paginar los resultados con query params.

**Ejemplo de request:** obtener las canciones del artista con id=1, ordenadas por titulo de manera ascendente + mostrando 5 resultados por pagina desde la primera página</br>
`GET /api/songs?artist=4&orderBy=title&sort=ASC&limit=5&page=1`</br>
Debería retornar un **JSON** con código **200**, o de no haber encontrado canciones un código **404.**

| Parámetro | Descripción                                                               | Ejemplo          |
| --------- | ------------------------------------------------------------------------- | ---------------- |
| `artist`  | Filtra por id del artista                                                 | `?artist=4`      |
| `orderBy` | Ordena por columna (`title`, `album`, `duration`, `genre`, `artist_name`) | `?orderBy=title` |
| `sort`    | Sentido del ordenamiento (`ASC` o `DESC`)                                 | `?sort=DESC`     |
| `limit`   | Cantidad de resultados por página                                         | `?limit=10`      |
| `page`    | Página actual (para paginación)                                           | `?page=2`        |

***

### GET /api/songs/:id
Devuelve **una** canción dado su id, ejemplo `GET /api/songs/3`</br>
Debería devolver 200 en caso de OK, 400 si falta parámetro, 404 si no fue encontrada.

### POST /api/songs/
**Crea** una nueva canción. Al ser un POST enviamos el request tiene body</br>

La duración se indica en minutos y dos decimales, por ejemplo 3.55</br>
genre y video pueden ir null.
```
{
  "id_artist": 4,
  "title": "Hola",
  "album": "El disco de tu corazón",
  "duration": "3.11",
  "genre": "",
  "video": ""
}
```
Debería devolver 201 si se crea la canción, 400 si los datos están incompletos.</br>

### PUT /api/songs/:id
Edita/Actualiza una canción existente. Al igual que POST, como hacemos PUT enviamos body<br>
Deberia devolver 200 en caso de OK, 400 si faltan datos, o 500 si hay un error al actualizar.

### Ejemplo de Requests en Postman
![ejemplo postman requests](postman_ejemplo.png)

***

> [!NOTE]
> Nota

> [!IMPORTANT]
> AL TESTEAR CON POSTMAN TENER EN CUENTA que los IDs de canciones y artistas no estan "completos", osea que puede pasar que un numero (como el 1 o 2) no corresponda a ningun artista, muchos fueron borrados o editados...
> No incluí views ya que tengo entendido que todo se testea con postman.
> POR AHORA no requiere autenticación

### TODO
+ TOKEN para realizar modificaciones (POST, PUT)
+ Podría agregar otra tabla a la BBDD para reseñas de canciones, o editar las tablas para que tenga mas sentido la funcionalidad
