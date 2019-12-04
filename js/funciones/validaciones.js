	function validar_nombre_apellido(val){
		var exp=/^[a-zαινσϊρ\s]{3,15}$/i;
		return exp.test( val);
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
	function validar_telefono(val){
		var exp=/^[\d]{8,15}$/;
		return exp.test( val);
	}
	function validar_dni(val){
		var exp=/^[0-9]{8}$/;
		return exp.test( val);
	}
	function validar_link(val){
		var exp=/^http(s)?:\/\/[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
		return exp.test( val);
	}

	/////////VALIDACION DATOS USUARIO
	function validar_form(e,estado){
		switch(e.name){
			case 'nombre': case 'apellido': case 'company':
				if(!validar_nombre_apellido(e.value)){
					if(e.value!==''){
						var tx=txt('Solo letras y espacios. Minimo 3, maximo 15.');
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
					var tx=txt('Minimo 3 caracteres, maximo 15. Sin espacios. No permite <,>,\',",;');
				}
				break;
			case 'clave_nueva':
				if(!validar_clave(e.value)){
					var tx=txt('Minimo 3 caracteres, maximo 15. Sin espacios. No permite <,>,\',",;');
				}
				break;
			case 'telefono':
				if(!validar_telefono(e.value)){
					var tx=txt('El numero es invalido. minimo 8 maximo 15, solo numeros.');
				}
				break;
			case 'dni':
				if(!validar_dni(e.value)){
					var tx=txt('El numero de dni es invalido.');
				}
				break;
			case 'monto':
				if(e.value>500000||e.value<2000){
					var tx=txt('El monto minimo son $2.000 y el maximo $500.000.');
				}
				break;
			case 'link':
				if(!validar_link(e.value)){
					var tx=txt('El link es invalido.');
				}
				break;
			case 'file':
				if(!validar_foto(e.value)){
					var tx=txt('Solo formato jpg, jpeg y png.');
				}
				break;
			case 'edad':
				var fecha = e.value.split("-");
				function isDate18orMoreYearsOld(day, month, year) {
					return  (new Date(year+18, month-1, day) > new Date())
				}
				if (parseInt(fecha[0], 10)<1935||2020<parseInt(fecha[0], 10)) {
					var tx = t.xt('Debes ser mayor de 18 y menos de 90');
				}
				else if(isDate18orMoreYearsOld(parseInt(fecha[2], 10), parseInt(fecha[1], 10), parseInt(fecha[0], 10))){
					var tx = txt('Debes ser mayor de 18 y menos de 90');
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
			if(p!=null&&p.className==="mensaje-validacion"){
				rc(p.parentNode,p);
			}
		}
	}
