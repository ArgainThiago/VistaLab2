let fechaActual = new Date();
fechaActual.setHours(0,0,0,0);
let mes = fechaActual.getMonth();
let anio = fechaActual.getFullYear();

const calendarioDiv = document.getElementById("calendario");
const mesesNombres = ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
                       "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
const diasSemana = ["Lun","Mar","Mié","Jue","Vie","Sáb","Dom"];

function generarCalendario(mes, anio){
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
        if(fechaBoton < fechaActual){
            disabled = "disabled";
        }

        html += `<td><button onclick="location.href='Agendar_cita.php?fecha=${anio}-${mes+1}-${dia}'" class="dia-boton ${claseHoy}" ${disabled}>${dia}</button></td>`;

        if((dia + diaSemana - 1) % 7 === 0) html += "</tr><tr>";
    }
    html += "</tr></table>";
    calendarioDiv.innerHTML = html;
}

generarCalendario(mes, anio);

document.getElementById("mes-anterior").addEventListener("click", ()=>{
    mes--;
    if(mes < 0){
        mes = 11;
        anio--;
    }
    generarCalendario(mes, anio);
});

document.getElementById("mes-siguiente").addEventListener("click", ()=>{
    mes++;
    if(mes > 11){
        mes = 0;
        anio++;
    }
    generarCalendario(mes, anio);
});
