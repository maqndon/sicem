$(document).ready(function () {
	
	$('#emb').jtable({
		title: 'Embarcaciones Registradas',
		paging: true, //Enable paging
		pageSize: 10, //Set page size (default: 10)
		pageSizes: [10, 25, 50, 100, 250, 500, 1000],
		pageSizeChangeArea:true,
		selecting:true, // permite seleccionar un registro y queda marcado con un color x
		gotoPageArea:'combobox', //opciones combobox, textbox, none
		pageList:'normal',
		sorting: true, //Enable sorting
		columnResizable: true, //Disable column resizing
		columnSelectable: true, //Disable column selecting
		saveUserPreferences: true, //Actually, no need to set true since it's default
		defaultSorting: 'nombre ASC', //Set default sorting
		openChildAsAccordion: true,
		actions: {
				listAction: 'accionesBuques.php?action=list',
				createAction: 'accionesBuques.php?action=create',
				updateAction: 'accionesBuques.php?action=update',
				deleteAction: 'accionesBuques.php?action=delete'
		},
		toolbar:{
			items:[{
			tooltip: 'Haga click aquí para exportar a PDF',
			icon:'../imagenes/16x16/mimetypes/fb-pdf-icon_0.png',
			text:'Exportar a PDF',
			click: function(){
				alert('Esta función aún no está implementada');
				//window.location='registroBuquePDF.php';
				}
			},{
			tooltip: 'Haga click aquí para exportar a Excel',
			icon:'../imagenes/16x16/mimetypes/x-office-spreadsheet.png',
			text:'Exportar a Excel',
			click: function(){
				alert('Esta función aún no está implementada');
				}
			}]
		},
		fields: {
			id: {
				key: true,
				list: false
			},
			
				//"Datos del Propietario y/o Responsable"
				propietarios: {
					title: '',
					width: '5%',
					sorting: false,
					edit: false,
					create: false,
					visibility: 'fixed', //This column always will be shown
					listClass: 'child-opener-image-column',
					display: function (data) {
						//Create an image that will be used to open child table
						var $img = $('<img class="child-opener-image" src="../css/themes/metro/user.png" title="Datos del Propietario" />');
						//Open child table when user clicks the image
						$img.click(function () {
							$('#emb').jtable('openChildTable',
									$img.closest('tr'),
									{
										title: 'Datos del Propietario y/o Responsable de <b>' + data.record.nombre + '</b>',
										columnResizable: false,
										actions: {
											listAction: 'accionesPropietario.php?action=list&matricula=' + data.record.matricula,
											createAction: 'accionesPropietario.php?action=create&matricula=' + data.record.matricula,
											deleteAction: 'accionesPropietario.php?action=delete',
											updateAction: 'accionesPropietario.php?action=update'
										},
										fields: {
											idpro: {
												title:'',
												key: true,
												list:false
											},
											protipoid: {
												title: 'Condición',
												width:'1%',
												visibility: 'fixed', //This column always will be shown
												options:'getActividad.php?action=getTipoProId',
												display: function (data){
													return '<b>'+data.record.protiponombre+'</b>';
													},
												inputClass: 'validate[required]'
											},
											ced: {
												title:'Cédula',
												visibility: 'fixed', //This column always will be shown
												width:'1%',
												inputClass: 'validate[required]'
											},
											nombres: {
												title: 'Nombres',
												visibility: 'fixed', //This column always will be shown
												inputClass: 'validate[required]'
											},
											apellidos: {
												title: 'Apellidos',
												visibility: 'fixed', //This column always will be shown
												inputClass: 'validate[required]'
											},
											tel: {
												title:'Teléfono',
												visibility: 'fixed', //This column always will be shown
											},
											cel: {
												visibility: 'hidden', //This column always will be shown
												title: 'Celular',
												list: true
											},
											fax: {
												title: 'Fax',
												visibility: 'hidden', //This column always will be shown
												list: true,
												//inputClass: 'validate[required]'
											},
											email: {
												list: true,
												title: 'Correo',
												visibility: 'hidden', //This column always will be shown
												type: 'email',
											},
											direccion: {
												title: 'Dirección',
												visibility: 'hidden', //This column always will be shown
												width:'20%',
												type:'textarea',
											},
											promatricula:{
												title:'Matrícula',
												defaultValue:data.record.matricula,
												list:false,
												create:true,
												edit:true,
												type:'hidden',
												}
										},
										formCreated: function (event, data) {
											data.form.validationEngine();
										},
										formSubmitting: function (event, data) {
											return data.form.validationEngine('validate');
										},
										formClosed: function (event, data) {
											data.form.validationEngine('hide');
											data.form.validationEngine('detach');
										}
									}, function (data) { //opened handler
										data.childTable.jtable('load');
									});
						});
						//Return image to show on the person row
						return $img;
					}
				},
				
				//"Registro de Combustible" Cambiar el nombre de la listClass para opciones de CSS
				Registro: {
					title: '',
					width: '5%',
					sorting: false,
					edit: false,
					create: false,
					visibility: 'fixed', //This column always will be shown
					listClass: 'child-opener-image-column',
					display: function (registroData) {
						//Create an image that will be used to open child table
						var $img = $('<img class="child-opener-image" src="../css/themes/metro/list_metro.png" title="Datos del Registro" />');
						//Open child table when user clicks the image
						$img.click(function () {
							$('#emb').jtable('openChildTable',
									$img.closest('tr'), //Parent row
									{
										//title: registroData.record.registro + ' - Exam Results',
										title: 'Datos del Registro de Combustible de <b>' + registroData.record.nombre + '</b>',
										columnResizable: true,
										actions: {
											listAction: 'accionesRegistro.php?action=list&matricula=' + registroData.record.matricula,
											createAction: 'accionesRegistro.php?action=create&matricula=' + registroData.record.matricula,
											deleteAction: 'accionesRegistro.php?action=delete',
											updateAction: 'accionesRegistro.php?action=update'
										},
										toolbar:{
											items:[{
											tooltip: 'Haga click aquí para exportar PDF',
											icon:'../imagenes/16x16/mimetypes/fb-pdf-icon_0.png',
											text:'Exportar PDF',
											click: function(){
												window.location='registroBuquePDF.php?matricula='+ registroData.record.matricula;
												}
											}]
										},
										fields: {
											idregistro: {
												title:'id',
												key: true,
												create: false,
												edit: false,
												list: false
											},
											codregistro: {
												title: 'Código de Registro',
												//width: '40%',
												visibility: 'fixed', //This column always will be shown
												inputClass: 'validate[required]'
											},
											idestadoreg: { // id del estado
												title: 'Estado',
												options:'getEstados.php?action=getEstados',
												//width: '30%',
												list: false,
												display: function (data) {
													   return(data.record.idestadoreg);
													},
											},
											idciudadreg: {
												title: 'Ciudad',
												//width: '30%',
												list:false,
												sorting: false, //This column is not sortable!
												display: function (data) {
														return(data.record.idciudadreg);
													},
												dependsOn: 'idestadoreg', //Cities depends on countries. Thus, jTable builds cascade dropdowns in create/edit form!
												options: function (data) {
													if (data.source == 'list') {
														//Return url of all cities for optimization. 
														//Since this method is called for each row on the table and jTable caches options based on this url.
														return 'getEstados.php?action=getciudad&idestado=0';
													}

													//This code runs when user opens edit/create forms or changes country combobox on an edit/create form.
													data.source == 'edit' || data.source == 'create'
													return 'getEstados.php?action=getciudad&idestado=' + data.dependedValues.idestadoreg;
												}
											},
											pbid: {
												title: 'Puerto Base',
												//width: '40%',
												inputClass: 'validate[required]',
												visibility: 'fixed', //This column always will be shown
												display: function (data) {
													return(data.record.pbnombre);
												},
												dependsOn: 'idciudadreg', //Cities depends on countries. Thus, jTable builds cascade dropdowns in create/edit form!
												options: function (data) {
													if (data.source == 'list') {
														//Return url of all cities for optimization. 
														//Since this method is called for each row on the table and jTable caches options based on this url.
														return 'getEstados.php?action=getPuerto&idciudad=0';
													}

													//This code runs when user opens edit/create forms or changes country combobox on an edit/create form.
													data.source == 'edit' || data.source == 'create'
													return 'getEstados.php?action=getPuerto&idciudad=' + data.dependedValues.idciudadreg;
												}
											},											
											fecha_sol: {
												title: 'Fecha de Solicitud',
												//width: '30%',
												type: 'date',
												visibility: 'hidden', //This column always will be shown
												displayFormat: 'dd/mm/yy',
												inputClass: 'validate[required,custom[date]]'
											},
											fecha_rec: {
												title: 'Fecha de Recepción',
												//width: '30%',
												type: 'date',
												visibility: 'hidden', //This column always will be shown
												displayFormat: 'dd/mm/yy',
												inputClass: 'validate[required,custom[date]]'
											},
											fecha_reg: {
												title: 'Fecha de Registro',
												//width: '30%',
												type: 'date',
												displayFormat: 'dd/mm/yy',
												inputClass: 'validate[required,custom[date]]'
											},
											num_ofic: {
												title: '# Oficio',
												//width: '5%',
												//inputClass: 'validate[required]'
											},
											fecha_ofic: {
												title: 'Fecha de Oficio',
												//width: '30%',
												visibility: 'hidden', //This column always will be shown
												type: 'date',
												displayFormat: 'dd/mm/yy',
												inputClass: 'validate[required,custom[date]]'
											},
											fecha_entrega: {
												title: 'Fecha de Entrega',
												//width: '30%',
												visibility: 'hidden', //This column always will be shown
												type: 'date',
												displayFormat: 'dd/mm/yy',
												inputClass: 'validate[required,custom[date]]'
											},
											regmatricula: {
												list:true,
												create:true,
												edit:true,
												display: function (data) {
													return(registroData.record.matricula);
												},
												type: 'hidden',
												title: 'Matrícula',
												//width: '10%',
											}
										},
										formCreated: function (event, data) {
											data.form.validationEngine();
										},
										formSubmitting: function (event, data) {
											return data.form.validationEngine('validate');
										},
										formClosed: function (event, data) {
											data.form.validationEngine('hide');
											data.form.validationEngine('detach');
										}
									}, function (data) { //opened handler
										data.childTable.jtable('load');
									});
						});
						//Return image to show on the person row
						return $img;
					}
				},
				
				//"Certificado de Arqueo" Cambiar el nombre de la listClass para opciones de CSS
				Arqueo: {
					title: '',
					width: '5%',
					sorting: false,
					edit: false,
					create: false,
					visibility: 'fixed', //This column always will be shown
					listClass: 'child-opener-image-column',
					display: function (arqueoData) {
						//Create an image that will be used to open child table
						var $img = $('<img class="child-opener-image" src="../css/themes/metro/arqueo.png" title="Datos del Arqueo" />');
						//Open child table when user clicks the image
						$img.click(function () {
							$('#emb').jtable('openChildTable',
									$img.closest('tr'), //Parent row
									{
										title: 'Certificado de Arqueo de <b>' + arqueoData.record.nombre + '</b>',
										columnResizable: false,
										actions: {
											listAction: 'accionesArqueo.php?action=list&matricula=' + arqueoData.record.matricula,
											createAction: 'accionesArqueo.php?action=create&matricula=' + arqueoData.record.matricula,
											deleteAction: 'accionesArqueo.php?action=delete',
											updateAction: 'accionesArqueo.php?action=update'
										},
										fields: {
											idarqueo: {
												title:'id',
												key: true,
												create: false,
												display: function (arqueoData) {
													   return(arqueoData.record.idarqueo);
													},
												edit: false,
												list: false
											},
											arqmatricula: {
												title: 'Matrícula',
												defaultValue:arqueoData.record.matricula,
												type:'hidden',
												//width: '40%',
												list:false,
											},
											num: { // id del estado
												title: 'N° Certificado',
												//width: '30%',
												inputClass: 'validate[required]',
											},
											fecha_arq: {
												title: 'Fecha de Expedición',
												display: function (arqueoData) {
													if(!arqueoData.record.fecha_arq){	
													return '<b>Null</b>';
													}else{
														return(arqueoData.record.fecha_arq);
														}
													},
												type:'date',
												//width: '30%',
												//list:true,
												sorting: false, //This column is not sortable!
												//inputClass: 'validate[required,custom[date]]'
											},
											idtipocomb: {
												title: 'Combustible',
												//width: '40%',
												options:'getActividad.php?action=getTipoComb',
												display: function (data){
													return(data.record.combustible);
													},
												inputClass: 'validate[required]',
											},											
											cap: {
												title: 'Cap. de Alm. (Lts)',
												inputClass:'validate[required,custom[number]]',
												//width: '30%',
												display: function(data){
													if(data.record.cap){
													return data.record.cap.replace('.',',');
												}
													},
											},
											hp: {
												title: 'HP',
												inputClass:'validate[required,custom[number]]',
												//width: '30%',
												display: function(data){
													if(data.record.hp){
													return data.record.hp.replace('.',',');
												}
													},
											},
											eslora: {
												title: 'Eslora (Mts)',
												inputClass:'validate[required,custom[number]]',
												display: function(data){
													if(data.record.eslora){
													return data.record.eslora.replace('.',',');
												}
													},
												//width: '30%',
											},
											manga: {
												title: 'Manga (Mts)',
												inputClass:'validate[required,custom[number]]',
												//width: '5%',
												display: function(data){
													if(data.record.manga){
													return data.record.manga.replace('.',',');
												}
													},
											},
											puntal: {
												title: 'Puntal (Mts)',
												inputClass:'validate[required,custom[number]]',
												//width: '30%',
												display: function(data){
													if(data.record.puntal){
													return data.record.puntal.replace('.',',');
												}
													},
											},
											bruto: {
												title: 'Arqueo Bruto',
												inputClass:'validate[required,custom[number]]',
												//width: '30%',
												display: function(data){
													if(data.record.bruto){
													return data.record.bruto.replace('.',',');
												}
													},
											},
											neto: {
												list:true,
												//inputClass:'validate[required,custom[number]]',
												create:true,
												edit:true,
												title: 'Arqueo Neto',
												display: function(data){
													if(data.record.neto){
													return data.record.neto.replace('.',',');
												}else{
													return '<b>Null</b>';
													}
													},
												//width: '10%',
											}
										},
										formCreated: function (event, data) {
											data.form.validationEngine();
										},
										formSubmitting: function (event, data) {
											return data.form.validationEngine('validate');
										},
										formClosed: function (event, data) {
											data.form.validationEngine('hide');
											data.form.validationEngine('detach');
										}
									}, function (data) { //opened handler
										data.childTable.jtable('load');
									});
						});
						//Return image to show on the person row
						return $img;
					}
				},
				
//Desde aqui ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				//"Detalles del Cupo de Combustible" Cambiar el nombre de la listClass para opciones de CSS
				Cupo: {
					title: '',
					width: '5%',
					sorting: false,
					edit: false,
					create: false,
					visibility: 'fixed', //This column always will be shown
					listClass: 'child-opener-image-column',
					display: function (cupoData) {
						//Create an image that will be used to open child table
						var $img = $('<img class="child-opener-image" src="../css/themes/metro/cupo.png" title="Detalles del Cupo" />');
						//Open child table when user clicks the image
						$img.click(function () {
							$('#emb').jtable('openChildTable',
									$img.closest('tr'), //Parent row
									{
										title: 'Cupo de Combustible de <b>' + cupoData.record.nombre + '</b>',
										columnResizable: false,
										actions: {
											listAction: 'accionesCupo.php?action=list&matricula=' + cupoData.record.matricula,
											createAction: 'accionesCupo.php?action=create&matricula=' + cupoData.record.matricula,
											deleteAction: 'accionesCupo.php?action=delete',
											updateAction: 'accionesCupo.php?action=update'
										},
										fields: {
											idcupo: {
												title:'id',
												key: true,
												create: false,
												display: function (cupoData) {
													   return(cupoData.record.idcupo);
													},
												edit: false,
												list: false
											},
											cupomatricula: {
												title: 'Matrícula',
												defaultValue:cupoData.record.matricula,
												type:'hidden',
												//width: '40%',
											},
											codreg: { // código de registro de combustible
												title: 'Código del Registro',
												//width: '30%',
												//inputClass: 'validate[required]',
												//defaultValue:dataCupo.record.codreg,
												//visibility:'hidden',
												list:false,
												create:false,
												edit:false,
												//type:'hidden',
											},
											faena: {
												title: 'Días de Faena',
												//width: '30%',
												//list:true,
												sorting: false, //This column is not sortable!
												inputClass: 'validate[required,custom[number]]'
											},
											horas: {
												title: 'Horas de Servicio',
												//width: '40%',
												inputClass: 'validate[custom[number]]',
											},											
											sol_lts: {
												title: 'Cupo Mensual Solicitado',
												inputClass:'validate[custom[number]]',
												//width: '30%',
											},
											sol_cupo: {
												title: 'Cupo Anual Solicitado',
												inputClass:'validate[custom[number]]',
											},
											formula: {
												title: 'Cupo Según Fórmula',
												inputClass:'validate[required,custom[number]]',
												//width: '5%',
											},
											cupo_anual: {
												title: 'Cupo Anual (Otorgado)',
												inputClass:'validate[required,custom[number]]',
												//width: '30%',
											},

										},
										formCreated: function (event, data) {
											data.form.validationEngine();
										},
										formSubmitting: function (event, data) {
											return data.form.validationEngine('validate');
										},
										formClosed: function (event, data) {
											data.form.validationEngine('hide');
											data.form.validationEngine('detach');
										}
									}, function (data) { //opened handler
										data.childTable.jtable('load');
									});
						});
						//Return image to show on the person row
						return $img;
					}
				},
//Hasta aqui ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
				
			matricula: {
				title: 'Matrícula',
				visibility: 'fixed', //This column always will be shown
				//width: '40%',
			},
			nombre: {
				title: 'Nombre',
				visibility: 'fixed', //This column always will be shown
				//width: '40%',
			},
			bandera: {
				title: 'Bandera',
				display: function(data){
					if (data.record.bandera=='Venezolana'){
						return('<img src="../imagenes/22x22/flags/ven.png" alt="Ven" title="Venezolana">');
						}
					}
				,
				//width: '30%',
				sorting: false, //This column is not sortable!
				//type: 'date',
			},
			idestado: { // id del estado
				title: 'Estado',
				options:'getEstados.php?action=getEstados',
				//width: '30%',
				list: true,
				display: function (data) {
					   return(data.record.estado);
					},
			},
			idciudad: {
				title: 'Ciudad',
				//width: '30%',
				sorting: false, //This column is not sortable!
				display: function (data) {
						return(data.record.ciudad);
					},
				dependsOn: 'idestado', //Cities depends on countries. Thus, jTable builds cascade dropdowns in create/edit form!
				options: function (data) {
					if (data.source == 'list') {
						//Return url of all cities for optimization. 
						//Since this method is called for each row on the table and jTable caches options based on this url.
						return 'getEstados.php?action=getciudad&idestado=0';
					}

					//This code runs when user opens edit/create forms or changes country combobox on an edit/create form.
					data.source == 'edit' || data.source == 'create'
					return 'getEstados.php?action=getciudad&idestado=' + data.dependedValues.idestado;
				}
			},

			idtipo: {
				title: 'Tipo',
				//width: '30%',
				// En la BBDD hay un sólo registro en la tabla tbl_tipo, ya que el sistema
				// de momento es para embarcaciones menores
				//options:'getActividad.php?action=getTipo',
				defaultValue:'1',
				sorting: false, //This column is not sortable!
				type: 'hidden',
				create: true,
				edit: true,
				display: function (data) {
					return(data.record.tipo);
				},
			},
			idactividad: {
				title: 'Actividad',
				options:'getActividad.php?action=getActividad',
				display: function (data) {
					return(data.record.actividad);
					},
				//width: '30%',
				sorting: true, //This column is not sortable!
				//options: { 'M': 'Male', 'F': 'Female' },
			},
			iduso: {
				title: 'Uso',
				//width: '30%',
				options:'getActividad.php?action=getUso',
				display: function (data) {
					return(data.record.uso);
					},
				sorting: true, //This column is not sortable!
				//type: 'date',
			},
			fecha_irn: {
				title: 'Fecha IRN',
				//width: '30%',
				visibility: 'hidden', //This column always will be shown
				sorting: false, //This column is not sortable!
				type: 'date',
				displayFormat:'dd/mm/yy',
			},
			fecha_insp: {
				title: 'Fecha Inspección',
				visibility: 'hidden', //This column always will be shown
				//width: '30%',
				sorting: false, //This column is not sortable!
				type: 'date',
				displayFormat:'dd/mm/yy',
			},
		},
		
			//Initialize validation logic when a form is created
			formCreated: function (event, data) {
				data.form.find('input[name="matricula"]').addClass('validate[required]');
				data.form.find('input[name="nombre"]').addClass('validate[required]');
				data.form.find('input[name="bandera"]').addClass('validate[required]');
				data.form.find('input[name="idciudad"]').addClass('validate[required]');
				data.form.find('input[name="idactividad"]').addClass('validate[required]');
				data.form.find('input[name="iduso"]').addClass('validate[required]');
				data.form.find('input[name="idtipo"]').addClass('validate[required]');
				
				//data.form.find('input[name="email"]').addClass('validate[required,custom[email]]');
				data.form.validationEngine();
			},
			//Validate form when it is being submitted
			formSubmitting: function (event, data) {
				return data.form.validationEngine('validate');
			},
			//Dispose validation logic when form is closed
			formClosed: function (event, data) {
				data.form.validationEngine('hide');
				data.form.validationEngine('detach');
			}
	});
	
	//Load person list from server
	$('#emb').jtable('load');
	
});
