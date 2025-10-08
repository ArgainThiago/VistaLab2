let fechaActual = new Date();
fechaActual.setHours(0,0,0,0);
let mes = fechaActual.getMonth();
let anio = fechaActual.getFullYear();

const calendarioDiv = document.getElementById("calendario");
const mesesNombres = ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
                       "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
const diasSemana = ["Lun","Mar","Mié","Jue","Vie","Sáb","Dom"];

function generarCalendario(mes, anio, diasDisponibles){
    const primerDia = new Date(anio, mes, 1).getDay();
    const diasMes = new Date(anio, mes + 1, 0).getDate();

    let html = `<h1>${mesesNombres[mes]} ${anio}</h1>`;
    html += "<table><tr>";
    for(let d of diasSemana) html += `<th>${d}</th>`;
    html += "</tr><tr>";

    let diaSemana = (primerDia === 0) ? 7 : primerDia;
    for(let i = 1; i < diaSemana; i++) html += "<td></td>";

    for(let dia = 1; dia <= diasMes; dia++){
        let claseHoy = "";
        if(dia === fechaActual.getDate() && mes === fechaActual.getMonth() && anio === fechaActual.getFullYear()){
            claseHoy = "hoy";
        }

        let fechaBoton = new Date(anio, mes, dia);
        let disabled = "";
        let diaStr = dia.toString().padStart(2, '0');
        let mesStr = (mes+1).toString().padStart(2, '0');
        let fechaFormateada = `${anio}-${mesStr}-${diaStr}`;

        if(fechaBoton < fechaActual || !diasDisponibles.includes(fechaFormateada)){
            disabled = "disabled";
        }

        html += `<td><button onclick="irHorario('${fechaFormateada}')" class="dia-boton ${claseHoy}" ${disabled}>${dia}</button></td>`;

        if((dia + diaSemana - 1) % 7 === 0) html += "</tr><tr>";
    }
    html += "</tr></table>";
    calendarioDiv.innerHTML = html;
}

function irHorario(fecha){
    window.location.href = `horario.php?fecha=${fecha}`;
}

function cargarDiasDisponibles(){
    const cedula_d = document.getElementById("cedula_d").value;
    if(!cedula_d) return;

    fetch(`obtener_dias_disponibles.php?cedula_d=${cedula_d}`)
    .then(response => response.json())
    .then(data => {
        generarCalendario(mes, anio, data);
    });
}

document.getElementById("mes-anterior").addEventListener("click", ()=>{
    mes--;
    if(mes < 0){
        mes = 11;
        anio--;
    }
    cargarDiasDisponibles();
});

document.getElementById("mes-siguiente").addEventListener("click", ()=>{
    mes++;
    if(mes > 11){
        mes = 0;
        anio++;
    }
    cargarDiasDisponibles();
});

cargarDiasDisponibles();
