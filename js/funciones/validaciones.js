	function validar_nombre_apellido(val){
		var exp=/^[a-záéíóúñ\s]+$/i;
		return exp.test( val);
	}
	function validar_fecha(val){
		var exp=/^(0?[1-9]|1[0-9]|2[0-9]|3[0-1])(\/|\-)(0?[1-9]|1[0-2])(\/|\-)(19[2-9][0-9]|2000)$/;
		return exp.test(val);
	}
	function validar_foto(val){
		var exp=/^.+(.jpe?g|.png)$/i;
		return exp.test(val); 
	}
	function validar_email(val){
		var exp=/^([a-zA-Z\d\-\.]{3,25}@[a-z]{3,15}\.[a-z]{2,4})?$/;
		return exp.test( val);
	}
	function validar_clave(val){
		var exp=/^([a-zA-Z\d_#,;~@%&\\\!\$\^\*\(\)\-\+\=\{\}\[\]\:\'\\<\>\.\?\|]{3,15})?$/;
		return exp.test( val);
	}
	function validar_titulo(val){
		var exp=/^([a-zA-Z\d\s_#,;@%&\\\!\$\*\(\)\-\+\=\{\}\[\]\:\'\\<\>\.\?\|]{3,200})?$/;
		return exp.test( val);
	}



	/////////VALIDACION DATOS USUARIO
	function validar_form(e,estado){
		switch(e.name){
			case 'nombre': case 'apellido':
				if(!validar_nombre_apellido(e.value)){
					if(!e.value==''){
						var tx=txt('Solo letras y espacios. Mínimo 3, máximo 15');
					}
				}
				break;
			case 'email':
				if(!validar_email(e.value)){
					var tx=txt('El email es invalido.');
				}
				break;
			case 'clave':
				if(!validar_clave(e.value)){
					var tx=txt('Minimo 3 caracteres, máximo 15. Sin espacios. No permite <,>,\',",;');
				}
				break;
			case 'clave_nueva':
				if(!validar_clave(e.value)){
					var tx=txt('Minimo 3 caracteres, máximo 15. Sin espacios. No permite <,>,\',",;');
				}
				break;
			case 'edad':
				var edad = new Date(e.value);
				edad=edad.getDate()+"-"+(edad.getMonth()+1)+"-"+edad.getFullYear();
				if(!validar_fecha(edad)){
					var tx=txt('Debes ser mayor de 16 años.');
				}
				break;
		}
		if(tx){
			e.style.borderBottom='solid red 1px';
			p=ce('p');
			p.className='mensaje-validacion';
			ac(p,tx);
			e.parentNode.insertBefore(p,e.nextSibling);
		}
		else{
			e.style.borderBottom='1px solid #aaa';
			var p=e.nextSibling;
			if(p!=null&&p.className=="mensaje-validacion"){
				rc(p.parentNode,p);
			}
		}
	}
