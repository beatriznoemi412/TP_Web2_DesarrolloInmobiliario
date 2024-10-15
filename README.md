INTEGRANTES
 .Lucia Micaela Moreira 
 .Beatriz Noemí MuñoZ

TPE _ Parte1:

DESCRIPCION
Nuestro trabajo especial estará enfocado en el desarrollo de una plataforma inmobiliaria utilizando PHP, ya que es el lenguaje principal abordado dentro de la materia. El proyecto tiene como objetivo crear una aplicación web que permita la gestión de propiedades inmobiliarias. Esta plataforma se diseñará para optimizar los procesos de búsqueda, registro y administración de inmuebles.

La plataforma inmobiliaria incluirá funcionalidades esenciales:
Con dos tablas para relacionar venta y vendedores de los inmuebles, y su interrelación, a través de id_vendedor y la clave foránea.

RF DER
![Diagrama de Relaciones](images/tablaRelacional.png)

TPE - Parte 2: Desarrollo de un Sitio Web Dinámico

 Descripción del Proyecto

Este proyecto consiste en un sitio web dinámico que permite la visualización y administración de ítems y categorías. Los usuarios pueden acceder a un listado de ítems y categorías sin necesidad de iniciar sesión, mientras que hay un administrador que tiene acceso a una sección restringida para gestionar los datos.

usuario:webadmin
HASH: $2a$12$mvhk0vIlA2p3LU.cQw/OxOrWxQFOk71l0Eq8I94pvcQTF5Z32icBu
Contraseña: admin

Funcionalidades Principales

Secciones Públicas
 Listado de Ítems: Muestra todos los ítems disponibles(ventas), incluyendo sus detalles y la categoría correspondiente.
 Detalle de Ítem: Permite la navegación a la vista de cada ítem (venta) de forma individual.
 Listado de Categorías: Visualiza categoría vendedores.
 Ítems por Categoría: Filtra y muestra los ítems que pertenecen a la categoría vendedores.

Sección Administrativa
Inicio de Sesión: El administrador puede ingresar con el usuario `webadmin` y la contraseña `admin`.
Gestión de Ítems: El administrador puede agregar, editar y eliminar ítems, así como seleccionar la categoría correspondiente para cada ítem.
Gestión de Categorías: Permite la administración de la categoría, incluyendo la opción de agregar, editar y eliminar categorías.
Subida de Imágenes: El administrador pueden subir imágenes al crear ítems.

Requisitos Técnicos

Servidor Web: Apache
Base de Datos: MySQL
Estructura de Archivos: Utiliza el patrón MVC y plantillas en phtml para la generación de vistas.
URLs Semánticas: Todas las rutas son semánticas para mejorar la usabilidad y SEO.

Instalación

Para desplegar el sitio en un servidor local:
http://localhost/web2-1°EntregaTP/






