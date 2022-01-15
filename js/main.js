(function () {
    document.addEventListener('DOMContentLoaded', function (event) {
        const formulario = document.querySelector('#contacto');
        const listadoContactos = document.querySelector('#listado-contactos tbody');
        const inputBuscador = document.querySelector('#buscar');

        listeners();

        function listeners() {
            //Cuando el formulario de crear o editar se ejecuta
            formulario.addEventListener('submit', leerFormulario);
            // Para eliminar el contacto
            if (listadoContactos) {
                listadoContactos.addEventListener('click', eliminarContacto);
            }
            // Buscador
            inputBuscador.addEventListener('input', buscarContactos);

            //Numero de Contactos
            numeroContactos();
        }

        function leerFormulario(e) {
            // console.log('Presionaste...');
            e.preventDefault();

            const nombre = document.querySelector('#nombre').value;
            const empresa = document.querySelector('#empresa').value;
            const telefono = document.querySelector('#telefono').value;

            const accion = document.querySelector('#accion').value;

            if (nombre === '' || empresa === '' || telefono === '') {
                mostrarNotificacion('Todos los campos son obligatorios', 'error');
            } else {
                // AJAX
                const infoContacto = new FormData();
                infoContacto.append('nombre', nombre);
                infoContacto.append('empresa', empresa);
                infoContacto.append('telefono', telefono);
                infoContacto.append('accion', accion);

                // console.log(...infoContacto);

                if (accion == 'crear') {
                    //Crear nuevo elemento
                    insertaBD(infoContacto);
                } else {
                    //Editar el contacto
                    //Leer el ID

                    const idRegistro = document.querySelector('#id').value;
                    infoContacto.append('id', idRegistro);
                    actualizarRegistro(infoContacto);
                }
            }
        }
        // Insertar en la base de datos via AJAX
        function insertaBD(datos) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'includes/modelos/modelo-contactos.php', true);

            xhr.onload = function () {
                if (this.status == 200) {
                    console.log(JSON.parse(xhr.responseText));
                    // Leemos la respuesta de PHP
                    const respuesta = JSON.parse(xhr.responseText);
                    // Inserta un nuevo elemento a la tabla

                    const nuevoContacto = document.createElement('tr');

                    nuevoContacto.innerHTML = `
                        <td>${respuesta.datos.nombre}</td>
                        <td>${respuesta.datos.empresa}</td>
                        <td>${respuesta.datos.telefono}</td>
                    `;

                    const contenedorAcciones = document.createElement('td');
                    //Icono editar
                    const iconoEditar = document.createElement('i');
                    iconoEditar.classList.add('fas', 'fa-pen-square');
                    const btnEditar = document.createElement('a');
                    btnEditar.appendChild(iconoEditar);
                    btnEditar.href = `editar.php?id=${respuesta.datos.id_insertado}`;
                    btnEditar.classList.add('btn-editar', 'boton');
                    //Agregar al padre
                    contenedorAcciones.appendChild(btnEditar);

                    //Icono eliminar
                    const iconoEliminar = document.createElement('i');
                    iconoEliminar.classList.add('fas', 'fa-trash-alt');
                    const btnEliminar = document.createElement('button');
                    btnEliminar.appendChild(iconoEliminar);
                    btnEliminar.setAttribute('data-id', respuesta.datos.id_insertado);
                    btnEliminar.classList.add('btn-borrar', 'boton');

                    contenedorAcciones.appendChild(btnEliminar);
                    //Agregarlo al tr
                    nuevoContacto.appendChild(contenedorAcciones);
                    //Agregar a los contactos
                    listadoContactos.appendChild(nuevoContacto);

                    // Resetear el formulario
                    document.querySelector('form').reset();

                    // Mostrar la notificacion
                    mostrarNotificacion('Contacto Creado Correctamente', 'correcto');

                    //Actualizamos el numero
                    numeroContactos();
                }
            };

            xhr.send(datos);
        }

        function eliminarContacto(e) {
            if (e.target.parentElement.classList.contains('btn-borrar')) {
                // Tomar el id
                const id = e.target.parentElement.getAttribute('data-id');
                const respuesta = confirm('Estas seguro?');
                if (respuesta) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', `includes/modelos/modelo-contactos.php?id=${id}&accion=borrar`, true);

                    xhr.onload = function () {
                        if (this.status === 200) {
                            const resultado = JSON.parse(xhr.responseText);
                            console.log(resultado);

                            if (resultado.respuesta == 'correcto') {
                                // Eliminar el registro del DOM
                                // console.log(e.target.parentElement.parentElement.parentElement);
                                e.target.parentElement.parentElement.parentElement.remove();

                                // Mostrar notificacion
                                mostrarNotificacion('Contacto Eliminado', 'correcto');
                                //Actualizamos el numero
                                numeroContactos();
                            } else {
                                // Mostramos una notificacion
                                mostrarNotificacion('Hubo un error al eliminar', 'error');
                            }
                        }
                    };

                    xhr.send();
                }
            }
        }

        function actualizarRegistro(datos) {
            console.log(...datos); // ... crea una copia

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'includes/modelos/modelo-contactos.php', true);

            xhr.onload = function () {
                if (this.status == 200) {
                    console.log(JSON.parse(xhr.responseText));
                    const respuesta = JSON.parse(xhr.responseText);

                    if (respuesta.respuesta === 'correcto') {
                        // Mostramos notificacion
                        mostrarNotificacion('Contacto Editado Correctamente', 'correcto');
                    } else {
                        // Error
                        mostrarNotificacion('Hubo un error al editar', 'error');
                    }

                    // Despues de 3 segundos redireccionar

                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 4000);
                }
            };

            xhr.send(datos);
        }
        //Notificacion Validacion
        function mostrarNotificacion(mensaje, clase) {
            const notificacion = document.createElement('div');
            notificacion.classList.add(clase, 'notificacion', 'sombra');
            notificacion.textContent = mensaje;

            formulario.insertBefore(notificacion, document.querySelector('form legend'));

            //Toggle ocultar y mostrar notificacion

            setTimeout(() => {
                notificacion.classList.add('visible');
                setTimeout(() => {
                    notificacion.classList.remove('visible');
                    setTimeout(() => {
                        notificacion.remove();
                    }, 500);
                }, 3000);
            }, 100);
        }

        function buscarContactos(e) {
            const expresion = new RegExp(e.target.value, 'i'),
                registros = document.querySelectorAll('tbody tr');

            registros.forEach((registro) => {
                registro.style.display = 'none';

                //console.log(registro.childNodes[1].textContent.replace(/\s/g, ' ').search(expresion));
                // .search regresa la posicion del string a partir de donde encontro la expresion, si no la encuentra regresa -1
                // Ejemplo expresion = All
                // registro = Allan por lo que search encuentra All a partir de la posicion 0 del registro, regresa 0
                // El if debajo tambien puede ser != -1
                if (registro.childNodes[1].textContent.replace(/\s/g, ' ').search(expresion) == 0) {
                    registro.style.display = 'table-row';
                }
                numeroContactos();
            });
        }

        function numeroContactos() {
            const totalContactos = document.querySelectorAll('tbody tr'),
                contenedorNumero = document.querySelector('.total-contactos span');
            let total = 0;

            totalContactos.forEach((contacto) => {
                if (contacto.style.display === '' || contacto.style.display === 'table-row') {
                    total++;
                }
            });
            contenedorNumero.textContent = total;
        }
    });
})();
