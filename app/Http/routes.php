<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
    return view('welcome');
})->name("inicio");

Route::get('/home', 'HomeController@index');


/* Routes para Comisiones */
Route::group(['prefix' => 'comisiones'], function() {
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
    Route::get('listado_agenda_comision', 'ComisionController@listado_agenda_comision')->name('listado_agenda_comision');
    Route::post('crear_comision', 'ComisionController@crear_comision')->name("crear_comision");
    Route::post('actualizar_comision', 'ComisionController@actualizar_comision')->name("actualizar_comision");
    Route::post('gestionar_asambleistas_comision', 'ComisionController@gestionar_asambleistas_comision')->name("gestionar_asambleistas_comision");
    Route::post('trabajo_comision', 'ComisionController@trabajo_comision')->name("trabajo_comision");
    Route::post('agregar_asambleistas_comision', 'ComisionController@agregar_asambleistas_comision')->name("agregar_asambleistas_comision");
    Route::post('retirar_asambleista_comision', 'ComisionController@retirar_asambleista_comision')->name("retirar_asambleista_comision");
    Route::post('listado_peticiones_comision', 'ComisionController@listado_peticiones_comision')->name("listado_peticiones_comision");
    Route::post('seguimiento_peticion_comision', 'ComisionController@seguimiento_peticion_comision')->name("seguimiento_peticion_comision");
    Route::post('listado_reuniones_comision', 'ComisionController@listado_reuniones_comision')->name("listado_reuniones_comision");
    Route::post('iniciar_reunion_comision', 'ComisionController@iniciar_reunion_comision')->name("iniciar_reunion_comision");
    Route::post('asistencia_comision', array('as' => 'asistencia_comision', 'uses' => 'ComisionController@asistencia_comision'));
    Route::post('registrar_asistencia_comision', 'ComisionController@registrar_asistencia_comision')->name('registrar_asistencia_comision');
    Route::post('finalizar_reunion_comision', 'ComisionController@finalizar_reunion_comision')->name('finalizar_reunion_comision');
    Route::post('historial_bitacoras', 'ComisionController@historial_bitacoras')->name('historial_bitacoras');
    Route::post('historial_dictamenes', 'ComisionController@historial_dictamenes')->name('historial_dictamenes');
    Route::post('convocatoria_comision', 'ComisionController@convocatoria_comision')->name('convocatoria_comision');
    Route::post('subir_documento_comision', 'ComisionController@subir_documento_comision')->name('subir_documento_comision');
    Route::post('subir_atestado_comision', 'ComisionController@subir_atestado_comision')->name('subir_atestado_comision');
    Route::post('crear_reunion_comision', array('as' => 'crear_reunion_comision', 'uses' => 'ComisionController@crear_reunion_comision'));
    Route::post('eliminar_reunion_comision', array('as' => 'eliminar_reunion_comision', 'uses' => 'ComisionController@eliminar_reunion_comision'));
    Route::post('enviar_convocatoria_comision', array('as' => 'enviar_convocatoria_comision', 'uses' => 'ComisionController@enviar_convocatoria_comision'));
    Route::post('subir_bitacora_comision',array('as'=>'subir_bitacora_comision','uses'=>'ComisionController@subir_bitacora_comision'));
    Route::post('guardar_bitacora_comision', array('as' => 'guardar_bitacora_comision', 'uses' => 'ComisionController@guardar_bitacora_comision'));
    Route::get('comisiones', 'ComisionController@mostrar_comisiones')->name("mostrar_comisiones");
    Route::get('administrar_comisiones', 'ComisionController@administrar_comisiones')->name("administrar_comisiones");
    Route::post('guardar_documento_comision','ComisionController@guardar_documento_comision')->name("guardar_documento_comision");
});



//rutas q aun no uso
Route::get('/HistorialBitacoras', function () {
    return view('Comisiones.HistorialBitacoras');
});
Route::get('/HistorialDictamenes', function () {
    return view('Comisiones.HistorialDictamenes');
});
Route::get('/TrabajoComision', function () {
    return view('Comisiones.TrabajoComision');
});
Route::get('/ConvocatoriaComision', function () {
    return view('Comisiones.convocatoria');
});
Route::get('/AsistenciaComision', function () {
    return view('Comisiones.AsistenciaComision');
});
Route::get('/discutir/{comision}/{id}', function () {
    return view('Comisiones.AdminstrarPuntoComision');
});

Route::group(['prefix' => 'reportes'], function() {
//AUN NO METAS REPORTES POR QUE ESTO HAY QUE TENER CUIDADO COMO TRARTARLOS xD
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
});

Route::post('buscar_planilla_dieta', 'ReportesController@buscar_planilla_dieta')->name("buscar_planilla_dieta");

Route::post('buscar_permisos_temporales', 'ReportesController@buscar_permisos_temporales')->name("buscar_permisos_temporales");

Route::post('buscar_bitacora_correspondencia', 'ReportesController@buscar_bitacora_correspondencia')->name("buscar_bitacora_correspondencia");

Route::post('buscar_permisos_permanentes', 'ReportesController@buscar_permisos_permanentes')->name("buscar_permisos_permanentes");

Route::post('buscar_asistencias', 'ReportesController@buscar_asistencias')->name("buscar_asistencias");

Route::post('buscar_consolidados_renta', 'ReportesController@buscar_consolidados_renta')->name("buscar_consolidados_renta");

Route::post('buscar_asambleistas_periodo', 'ReportesController@buscar_asambleistas_periodo')->name("buscar_asambleistas_periodo");

Route::post('buscar_asambleistas_cumple', 'ReportesController@buscar_asambleistas_cumple')->name("buscar_asambleistas_cumple");

Route::post('buscar_actas', 'PlantillasController@buscar_actas')->name("buscar_actas");

Route::post('buscar_acuerdos', 'PlantillasController@buscar_acuerdos')->name("buscar_acuerdos");



Route::post('buscar_dictamenes', 'PlantillasController@buscar_dictamenes')->name("buscar_dictamenes");

Route::post('buscar_actas_JD', 'PlantillasController@buscar_actas_JD')->name("buscar_actas_JD");

Route::post('Mensaje', 'ReportesController@Mensaje')->name("Mensaje");



/* Peticiones */
Route::group(['prefix' => 'peticiones'], function() {
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

});

Route::get('registrar_peticion', 'PeticionController@registrar_peticion')->name('registrar_peticion');
Route::get('monitoreo_peticion', 'PeticionController@monitoreo_peticion')->name('monitoreo_peticion');
//Route::get('listado_peticiones', 'PeticionController@listado_peticiones')->name('listado_peticiones');
Route::get('listado_peticiones', array('as' => 'listado_peticiones', 'uses' => 'PeticionController@listado_peticiones'));
Route::post('consultar_estado_peticion', 'PeticionController@consultar_estado_peticion')->name("consultar_estado_peticion");
Route::post('registrar_peticion_post', 'PeticionController@registrar_peticion_post')->name('registrar_peticion_post');


/* Reportes */

Route::get('/Reporte_permisos_permanentes', function () {
    return view('Reportes.Reporte_permisos_permanentes', ['resultados' => NULL]);
});
Route::get('/Reporte_permisos_permanentes/{tipo}', 'ReportesController@Reporte_permisos_permanentes');
Route::get('/Reporte_asistencias_sesion_plenaria', function () {
    return view('Reportes.Reporte_asistencias_sesion_plenaria', ['resultados' => NULL]);
});
Route::get('/Reporte_asistencias_sesion_plenaria/{tipo}', 'ReportesController@Reporte_asistencias_sesion_plenaria');
Route::get('/Reporte_inasistencias_sesion_plenaria_pdf/{tipo}', 'ReportesController@Reporte_inasistencias_sesion_plenaria_pdf');
Route::get('/Reporte_bitacora_correspondencia', function () {
    return view('Reportes.Reporte_bitacora_correspondencia', ['resultados' => NULL]);
});
Route::get('/Reporte_bitacora_correspondencia/{tipo}', 'ReportesController@Reporte_bitacora_correspondencia');
Route::get('/Reporte_planilla_dieta', function () {
    return view('Reportes.Reporte_planilla_dieta', ['resultados' => NULL]);
});


Route::get('buscar_periodo', 'ReportesController@buscar_periodo')->name('buscar_periodo');

Route::get('buscar_cumple', 'ReportesController@buscar_cumple')->name('buscar_cumple');





Route::get('/Reporte_Asambleista_Periodo/{tipo}', 'ReportesController@Reporte_Asambleista_Periodo');

Route::get('/Reporte_Asambleistas_Cumple/{tipo}', 'ReportesController@Reporte_Asambleistas_Cumple');

Route::get('/Reporte_planilla_dieta/{tipo}', 'ReportesController@Reporte_planilla_dieta');
Route::get('/Reporte_planilla_dieta_prof_Est_pdf/{tipo}', 'ReportesController@Reporte_planilla_dieta_prof_Est_pdf');
Route::get('/Reporte_planilla_dieta_prof_noDocpdf/{tipo}', 'ReportesController@Reporte_planilla_dieta_prof_noDocpdf');
Route::get('/Reporte_planilla_dieta_prof_Doc_pdf/{tipo}', 'ReportesController@Reporte_planilla_dieta_prof_Doc_pdf');
Route::get('/Reporte_consolidados_renta', function () {
    return view('Reportes.Reporte_consolidados_renta',['resultados'=>NULL]);
});
Route::get('/Reporte_consolidados_renta/{tipo}', 'ReportesController@Reporte_consolidados_renta');
Route::get('/Reporte_consolidados_renta_docente/{tipo}', 'ReportesController@Reporte_consolidados_renta_docente');
Route::get('/Reporte_constancias_renta', function () {
    return view('Reportes.Reporte_constancias_renta');
});
Route::get('/Reporte_constancias_renta/{tipo}', 'ReportesController@Reporte_constancias_renta');
Route::get('/Reporte_constancias_renta_JD', function () {
    return view('Reportes.Reporte_constancias_renta_JD');
});
Route::get('/Reporte_constancias_renta_JD/{tipo}', 'ReportesController@Reporte_constancias_renta_JD');


// PLANTILLAS
Route::group(['prefix' => 'plantillas'], function() {
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

});



Route::get('/Plantilla_Actas', function () {
    return view('Plantillas.Plantilla_actas', ['resultados' => NULL]);
});

Route::get('/Plantilla_Acuerdos', function () {
    return view('Plantillas.Plantilla_acuerdos', ['resultados' => NULL]);
});

Route::get('/Plantilla_dictamenes', function () {
    return view('Plantillas.Plantilla_dictamenes', ['resultados' => NULL]);
});


Route::get('/Plantilla_Actas_JD', function () {
    return view('Plantillas.Plantilla_actas_JD', ['resultados' => NULL]);
});

Route::get('/desc_Plantilla_actas/{tipo}', 'PlantillasController@desc_Plantilla_actas');
Route::get('/desc_Plantilla_acuerdos/{tipo}', 'PlantillasController@desc_Plantilla_acuerdos');
Route::get('/buscar_propuesta/{tipo}', 'PlantillasController@buscar_propuesta');
Route::get('/desc_Plantilla_dictamenes/{tipo}', 'PlantillasController@desc_Plantilla_dictamenes');

Route::get('/Reporte_permisos_temporales/{tipo}', 'ReportesController@Reporte_permisos_temporales');
Route::get('/Reporte_permisos_temporales', function () {
    return view('Reportes.Reporte_permisos_temporales', ['resultados' => NULL]);
});

Route::get('/Menu_reportes', function () {
    return view('Reportes.MenuReportes');
});

Route::get('/Menu_plantillas', function () {
    return view('Plantillas.MenuPlantilla');
});

Route::get('/Reporte_Convocatorias_pdf/{tipo}', 'ReportesController@Reporte_Convocatorias');
Route::get('/Reporte_Convocatorias', function () {
    return view('Reportes.Reporte_Convocatorias');
});


/* Routes para Agenda 
R-o-u-t-e:-:-g-e-t-(-'-/sesion_plenaria', function () {
    return view('Agenda.sesion_plenaria');
});
*/





Route::group(['prefix' => 'plenarias'], function() {
Route::post('sala_sesion_plenaria', array('as' => 'sala_sesion_plenaria', 'uses' => 'AgendaController@sala_sesion_plenaria'));
Route::post('iniciar_sesion_plenaria', array('as' => 'iniciar_sesion_plenaria', 'uses' => 'AgendaController@iniciar_sesion_plenaria'));
Route::post('discutir_punto_plenaria', array('as' => 'discutir_punto_plenaria', 'uses' => 'AgendaController@discutir_punto_plenaria'));
Route::post('agregar_propuesta', array('as' => 'agregar_propuesta', 'uses' => 'AgendaController@agregar_propuesta'));
Route::post('modificar_propuesta', array('as' => 'modificar_propuesta', 'uses' => 'AgendaController@modificar_propuesta'));
Route::post('guardar_votacion', array('as' => 'guardar_votacion', 'uses' => 'AgendaController@guardar_votacion'));
Route::post('agregar_intervencion', array('as' => 'agregar_intervencion', 'uses' => 'AgendaController@agregar_intervencion'));
Route::post('seguimiento_peticion_plenaria', array('as' => 'seguimiento_peticion_plenaria', 'uses' => 'AgendaController@seguimiento_peticion_plenaria'));
Route::post('retirar_punto_plenaria', array('as' => 'retirar_punto_plenaria', 'uses' => 'AgendaController@retirar_punto_plenaria'));
Route::post('resolver_punto_plenaria', array('as' => 'resolver_punto_plenaria', 'uses' => 'AgendaController@resolver_punto_plenaria'));
Route::post('fijar_puntos', array('as' => 'fijar_puntos', 'uses' => 'AgendaController@fijar_puntos'));
Route::post('nuevo_orden_plenaria', array('as' => 'nuevo_orden_plenaria', 'uses' => 'AgendaController@nuevo_orden_plenaria'));
Route::post('finalizar_sesion_plenaria', array('as' => 'finalizar_sesion_plenaria', 'uses' => 'AgendaController@finalizar_sesion_plenaria'));
Route::post('pausar_sesion_plenaria', array('as' => 'pausar_sesion_plenaria', 'uses' => 'AgendaController@pausar_sesion_plenaria'));
Route::post('comision_punto_plenaria', array('as' => 'comision_punto_plenaria', 'uses' => 'AgendaController@comision_punto_plenaria'));
Route::post('asignar_comision_punto', array('as' => 'asignar_comision_punto', 'uses' => 'AgendaController@asignar_comision_punto'));
Route::post('agregar_asambleistas_sesion', 'AgendaController@agregar_asambleistas_sesion')->name('agregar_asambleistas_sesion');
Route::post('gestionar_asistencia', array('as' => 'gestionar_asistencia', 'uses' => 'AgendaController@gestionar_asistencia'));
Route::post('cambiar_propietaria', array('as' => 'cambiar_propietaria', 'uses' => 'AgendaController@cambiar_propietaria'));
Route::post('obtener_datos_intervencion', 'AgendaController@obtener_datos_intervencion')->name("obtener_datos_intervencion");
Route::post('retiro_temporal', 'AgendaController@retiro_temporal')->name("retiro_temporal");
Route::get('descargar_documento/{id}', 'DocumentoController@descargar_documento')->name("descargar_documento");




});

// Pantalla publica
Route::get('historial_agendas', array('as' => 'historial_agendas', 'uses' => 'AgendaController@historial_agendas'));



/*
Route:: get('/GestionarAsistencia', function () {
    return view('Agenda.GestionarAsistencia');
});
*/
/*
Route::get('/IniciarSesionPlenaria', function () {
    return view('Agenda.IniciarSesionPlenaria');
});

Route::get('historial_agendas', function () {
    return view('Agenda.HistorialAgendas');
});
*/
Route::get("consultar_agendas_vigentes", "AgendaController@consultar_agendas_vigentes")->name("consultar_agenda_vigentes");
Route::post('detalles_punto_agenda', 'AgendaController@detalles_punto_agenda')->name("detalles_punto_agenda");

/* Routes Administracion */
Route::group(['prefix' => 'administracion'], function() {
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

});




Route::get('GestionarUsuarios', function () {return view('Administracion.GestionarUsuario');})->name("administracion_usuario");
Route::get('gestionar_plantillas', "AdministracionController@gestionar_plantillas")->name("gestionar_plantillas");
Route::get('gestionar_perfiles', "AdministracionController@gestionar_perfiles")->name("gestionar_perfiles");;
Route::get('registrar_usuario', "AdministracionController@registrar_usuario")->name("mostrar_formulario_registrar_usuario");;
Route::get('periodos_agu', "AdministracionController@mostrar_periodos_agu")->name("periodos_agu");
Route::get('parametros', array('as' => 'parametros', 'uses' => 'AdministracionController@parametros'));
Route::get('cambiar_perfiles', "AdministracionController@cambiar_perfiles")->name("cambiar_perfiles");
Route::get('cambiar_cargos_comision', "AdministracionController@cambiar_cargos_comision")->name("cambiar_cargos_comision");
Route::get('cambiar_cargos_junta_directiva', "AdministracionController@cambiar_cargos_junta_directiva")->name("cambiar_cargos_junta_directiva");
Route::get('descargar_plantilla/{id}', 'AdministracionController@descargar_plantilla')->name("descargar_plantilla");
Route::get('registro_permisos_temporales', 'AdministracionController@registro_permisos_temporales')->name("registro_permisos_temporales");
Route::get('baja_asambleista', 'AdministracionController@baja_asambleista')->name("baja_asambleista");
Route::get('dietas_asambleista', 'AdministracionController@dietas_asambleista')->name("dietas_asambleista");
Route::post('guardar_usuario', "AdministracionController@guardar_usuario")->name("guardar_usuario");
Route::post('actualizar_usuario', "AdministracionController@actualizar_usuario")->name("actualizar_usuario");
Route::post('guardar_periodo', "AdministracionController@guardar_periodo")->name("guardar_periodo");
Route::post('finalizar_periodo', "AdministracionController@finalizar_periodo")->name("finalizar_periodo");
Route::post('almacenar_parametro', array('as' => 'almacenar_parametro', 'uses' => 'AdministracionController@almacenar_parametro'));
Route::post('mostrar_asambleistas_comision_post', "AdministracionController@mostrar_asambleistas_comision_post")->name("mostrar_asambleistas_comision_post");
Route::post('actualizar_coordinador', "AdministracionController@actualizar_coordinador")->name("actualizar_coordinador");
Route::post('actualizar_secretario', "AdministracionController@actualizar_secretario")->name("actualizar_secretario");
Route::post('actualizar_cargo_miembro_jd', "AdministracionController@actualizar_cargo_miembro_jd")->name("actualizar_cargo_miembro_jd");
Route::post('actualizar_perfil_usuario', "AdministracionController@actualizar_perfil_usuario")->name("actualizar_perfil_usuario");
Route::post('agregar_perfiles', "AdministracionController@agregar_perfiles")->name("agregar_perfiles");
Route::post('administrar_acceso_modulos', "AdministracionController@administrar_acceso_modulos")->name("administrar_acceso_modulos");
Route::post('asignar_acceso_modulos', "AdministracionController@asignar_acceso_modulos")->name("asignar_acceso_modulos");
Route::post('agregar_plantillas', "AdministracionController@agregar_plantillas")->name("agregar_plantillas");
Route::post('almacenar_plantilla', "AdministracionController@almacenar_plantilla")->name("almacenar_plantilla");
Route::post('mostrar_delegados', "AdministracionController@mostrar_delegados")->name("mostrar_delegados");
Route::post('guardar_permiso', "AdministracionController@guardar_permiso")->name("guardar_permiso");
Route::post('dar_baja', "AdministracionController@modificar_estado_asambleista")->name("modificar_estado_asambleista");
Route::post('obtener_usuario', "AdministracionController@obtener_usuario")->name("obtener_usuario");
Route::post('busqueda_dietas_asambleista', "AdministracionController@busqueda_dietas_asambleista")->name("busqueda_dietas_asambleista");
Route::post('almacenar_dieta_asambleista', "AdministracionController@almacenar_dieta_asambleista")->name("almacenar_dieta_asambleista");






/* Asambleistas */
Route::group(['prefix' => 'asambleistas'], function() {
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

});




Route::get('listado_asambleistas_facultad', "AsambleistaController@listado_asambleistas_facultad");
Route::get('listado_asambleistas_comision', "AsambleistaController@listado_asambleistas_comision");
Route::get('listado_asambleistas_junta', "AsambleistaController@listado_asambleistas_junta");

/* Junta Directiva*/
Route::group(['prefix' => 'juntadirectiva'], function() {
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
// &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

});





Route::get('crear_convocatoria', array('as' => 'crear_convocatoria', 'uses' => 'MailController@crear_convocatoria'));
Route::get('convocatoria_jd', array('as' => 'convocatoria_jd', 'uses' => 'MailController@convocatoria_jd'));
Route::post('mailing_jd', array('as' => 'mailing_jd', 'uses' => 'MailController@mailing_jd'));
Route::get('trabajo_junta_directiva', array('as' => 'trabajo_junta_directiva', 'uses' => 'JuntaDirectivaController@trabajo_junta_directiva'));
Route::get('listado_peticiones_jd', array('as' => 'listado_peticiones_jd', 'uses' => 'JuntaDirectivaController@listado_peticiones_jd'));
Route::get('listado_reuniones_jd', array('as' => 'listado_reuniones_jd', 'uses' => 'JuntaDirectivaController@listado_reuniones_jd'));

Route::post('listado_sesion_plenaria', array('as' => 'listado_sesion_plenaria', 'uses' => 'JuntaDirectivaController@listado_sesion_plenaria'));
Route::post('agregar_puntos_jd', array('as' => 'agregar_puntos_jd', 'uses' => 'JuntaDirectivaController@agregar_puntos_jd'));
Route::post('crear_punto_plenaria', array('as' => 'crear_punto_plenaria', 'uses' => 'JuntaDirectivaController@crear_punto_plenaria'));
Route::post('ordenar_puntos_jd', array('as' => 'ordenar_puntos_jd', 'uses' => 'JuntaDirectivaController@ordenar_puntos_jd'));
Route::post('nuevo_orden', array('as' => 'nuevo_orden', 'uses' => 'JuntaDirectivaController@nuevo_orden'));


Route::post('seguimiento_peticion_jd', array('as' => 'seguimiento_peticion_jd', 'uses' => 'JuntaDirectivaController@seguimiento_peticion_jd'));
Route::get('seguimiento_peticion_individual_jd', array('as' => 'seguimiento_peticion_individual_jd', 'uses' => 'JuntaDirectivaController@seguimiento_peticion_individual_jd'));
Route::post('iniciar_reunion_jd', array('as' => 'iniciar_reunion_jd', 'uses' => 'JuntaDirectivaController@iniciar_reunion_jd'));
Route::post('puntos_agendados', array('as' => 'puntos_agendados', 'uses' => 'JuntaDirectivaController@puntos_agendados'));

Route::post('asistencia_jd', array('as' => 'asistencia_jd', 'uses' => 'JuntaDirectivaController@asistencia_jd'));
Route::post('finalizar_reunion_jd', array('as' => 'finalizar_reunion_jd', 'uses' => 'JuntaDirectivaController@finalizar_reunion_jd'));

Route::post('asignar_comision_jd', array('as' => 'asignar_comision_jd', 'uses' => 'JuntaDirectivaController@asignar_comision_jd'));
Route::post('agendar_plenaria', array('as' => 'agendar_plenaria', 'uses' => 'JuntaDirectivaController@agendar_plenaria'));
Route::get('lista_asignacion', array('as' => 'lista_asignacion', 'uses' => 'JuntaDirectivaController@lista_asignacion'));
Route::post('enlazar_comision', array('as' => 'enlazar_comision', 'uses' => 'JuntaDirectivaController@enlazar_comision'));

Route::post('historial_bitacoras_jd', array('as' => 'historial_bitacoras_jd', 'uses' => 'JuntaDirectivaController@historial_bitacoras_jd'));
Route::post('historial_dictamenes_jd', array('as' => 'historial_dictamenes_jd', 'uses' => 'JuntaDirectivaController@historial_dictamenes_jd'));

//Route::get('listado_agenda_plenaria_jd', array('as' => 'listado_agenda_plenaria_jd', 'uses' => 'JuntaDirectivaController@listado_agenda_plenaria_jd'));
Route::get('listado_agenda_plenaria_jd', 'JuntaDirectivaController@listado_agenda_plenaria_jd')->name('listado_agenda_plenaria_jd');
//Route::post('eliminar_agenda_creada_jd', array('as' => 'eliminar_agenda_creada_jd', 'uses' => 'JuntaDirectivaController@eliminar_agenda_creada_jd'));
//Route::post('generar_agenda_plenaria_jd', array('as' => 'generar_agenda_plenaria_jd', 'uses' => 'JuntaDirectivaController@generar_agenda_plenaria_jd'));
Route::post('eliminar_agenda_creada_jd', 'JuntaDirectivaController@eliminar_agenda_creada_jd')->name('eliminar_agenda_creada_jd');
Route::post('generar_agenda_plenaria_jd', 'JuntaDirectivaController@generar_agenda_plenaria_jd')->name("generar_agenda_plenaria_jd");

Route::get('generar_reuniones_jd', array('as' => 'generar_reuniones_jd', 'uses' => 'JuntaDirectivaController@generar_reuniones_jd'));

Route::post('crear_reunion_jd', array('as' => 'crear_reunion_jd', 'uses' => 'JuntaDirectivaController@crear_reunion_jd'));
Route::post('eliminar_reunion_jd', array('as' => 'eliminar_reunion_jd', 'uses' => 'JuntaDirectivaController@eliminar_reunion_jd'));
Route::post('enviar_convocatoria_jd', array('as' => 'enviar_convocatoria_jd', 'uses' => 'JuntaDirectivaController@enviar_convocatoria_jd'));

Route::post('subir_documento_jd', array('as' => 'subir_documento_jd', 'uses' => 'JuntaDirectivaController@subir_documento_jd'));
Route::post('guardar_documento_jd', array('as' => 'guardar_documento_jd', 'uses' => 'JuntaDirectivaController@guardar_documento_jd'));

Route::post('subir_bitacora_jd', array('as' => 'subir_bitacora_jd', 'uses' => 'JuntaDirectivaController@subir_bitacora_jd'));
Route::post('guardar_bitacora_jd', array('as' => 'guardar_bitacora_jd', 'uses' => 'JuntaDirectivaController@guardar_bitacora_jd'));

Route::post('subir_dictamen_jd', array('as' => 'subir_dictamen_jd', 'uses' => 'JuntaDirectivaController@subir_dictamen_jd'));
Route::post('guardar_dictamen_jd', array('as' => 'guardar_dictamen_jd', 'uses' => 'JuntaDirectivaController@guardar_dictamen_jd'));

Route::post('subir_acta_plenaria', array('as' => 'subir_acta_plenaria', 'uses' => 'JuntaDirectivaController@subir_acta_plenaria'));
Route::post('guardar_acta_plenaria', array('as' => 'guardar_acta_plenaria', 'uses' => 'JuntaDirectivaController@guardar_acta_plenaria'));


/*post*/

Route::post('registrar_asistencia', 'JuntaDirectivaController@registrar_asistencia')->name('registrar_asistencia');
/*
 *
\Mail::send('welcome', [], function ($message){
    $message->to('siarcaf@gmail.com')->subject('Testing mail');
});
*/

/* Routes generales */
Route::get('busqueda', 'DocumentoController@busqueda')->name('busqueda');
Route::post('buscar_documentos', 'DocumentoController@buscar_documentos')->name('buscar_documentos');
Route::get('descargar_documento/{id}', 'DocumentoController@descargar_documento')->name("descargar_documento");

Route::resource('photo','PhotoController');
Route::auth();

Route::get('/home', 'HomeController@index');
