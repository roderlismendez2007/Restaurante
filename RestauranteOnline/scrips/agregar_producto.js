// Función para agregar un producto al carrito de compras
function addProducto(idProducto, tokenUsuario) {

  // Crear un formulario con los datos del producto
  var formData = new FormData();
  formData.append('id', idProducto);
  formData.append('token', tokenUsuario);

  // Obtener el elemento que muestra el número de artículos en el carrito
  let numeroArticulosEnCarrito = document.getElementById("num_cart");

  // Crear una solicitud XMLHttpRequest
  var xhr = new XMLHttpRequest();
  
  // Configurar la solicitud
  xhr.open('POST', 'clases/Carrito.php', true);

  // Función para manejar la respuesta del servidor
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Parsear la respuesta JSON
        const respuesta = JSON.parse(xhr.responseText);

        // Si la respuesta es exitosa, actualizar el número de artículos en el carrito
        if (respuesta.ok) {
          numeroArticulosEnCarrito.innerHTML = respuesta.numero;
        }
      } else {
        console.error('Error en la solicitud. Estado:', xhr.status);
      }
    }
  };

  // Enviar la solicitud al servidor
  xhr.send(formData);
}
