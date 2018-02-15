function notificacion(titulo, contenido, tipo) {
    Lobibox.notify(tipo,  // Available types 'warning', 'info', 'success', 'error'
        {
            title: titulo,
            //soundPath: '{{ asset('libs/lolibox/sounds') }}',
            sound: false,
            msg: contenido,
            delayIndicator: false,
            showClass: 'zoomIn',
            hideClass: 'zoomOut',
            delay: 5000,
            size: 'mini'
        });

}

function generarPassword() {
    //Se define una cadena de caractares. Te recomiendo que uses esta.
    var cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    //Obtenemos la longitud de la cadena de caracteres
    var longitudCadena = cadena.length;

    //Se define la variable que va a contener la contraseña
    var pass = "";
    //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
    var longitudPass = 10;

    //Creamos la contraseña
    for (var i = 0; i < longitudPass; i++) {
        //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
        var pos = Math.random() * ((longitudCadena - 1));

        //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
        pass += cadena.substr(pos, 1);
    }
    return pass;
}
