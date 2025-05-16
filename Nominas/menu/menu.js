$(inicioMenu()); 

function inicioMenu(){
	//###########################################################################################################################################
	//Evento submit del formulario.--------------------------------------------------------------------------------
	/*Botón Guardar y continuar. */
	$("#frmPractica").submit(function(e){
		//Detengo el comportamiento normal del evento submit.
		e.preventDefault();	
		alert("hola");
		  
		  $(document).scrollTop(0);
		});

}