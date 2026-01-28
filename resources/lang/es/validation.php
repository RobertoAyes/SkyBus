<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El campo :attribute debe ser aceptado.',
    'active_url' => 'El campo :attribute no es una URL válida.',
    // ... (más reglas)

    'required' => 'El campo :attribute es obligatorio.', // <-- ¡Esta es la línea que corrige tu error!

    // ... (más reglas)

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines may be used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages cleaner.
    |
    */

    'attributes' => [
        // Puedes definir nombres amigables para tus campos, por ejemplo:
        'usuario_id' => 'ID de Cliente',
        'tarifa' => 'Tarifa Base',
        'nombre_cliente_buscador' => 'Nombre del Cliente',
        'punto_partida' => 'Punto de Partida',
    ],

];
