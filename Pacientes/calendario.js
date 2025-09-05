let fechaActual = new Date();
let mes = fechaActual.getMonth();  //número del mes actual (1-12)
let anio = fechaActual.getFullYear(); //el año actual 

const calendarioDiv = document.getElementById("calendario");//contenedor del calendario en el HTML
const mesesNombres = ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
                       "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];//los nombres de los meses que luego se van a mostrar en el titulo
const diasSemana = ["Lun","Mar","Mié","Jue","Vie","Sáb","Dom"];//son las abreviaturas de los dias de la semana para la tabla

function generarCalendario(mes, anio){
    const primerDia = new Date(anio, mes, 1).getDay(); //dia de la semana del primer día del mes (0=Domingo, 1=Lunes, ...)
    const diasMes = new Date(anio, mes+1, 0).getDate();//cantidad de días en el mes (28-31)

    let html = `<h1>${mesesNombres[mes]} ${anio}</h1>`;
    html += "<table><tr>";
    for(let d of diasSemana) html += `<th>${d}</th>`;
    html += "</tr><tr>";
//crea el título del calendario con mes y año
//comienza la tabla con los encabezados de la semana

    let diaSemana = (primerDia == 0) ? 7 : primerDia; 
    for(let i=1; i<diaSemana; i++) html += "<td></td>";

    for(let dia=1; dia<=diasMes; dia++){
        let claseHoy = "";
        if(dia === fechaActual.getDate() && mes === fechaActual.getMonth() && anio === fechaActual.getFullYear()){
            claseHoy = "hoy";//aplica la clase hoy si coincide con la fecha actual
        }
        html += `<td><button onclick="location.href='Agendar_cita.php'" class="dia-boton ${claseHoy}">${dia}</button></td>`;

        if((dia + diaSemana -1)%7==0) html+="</tr><tr>";//la condición ((dia + diaSemana -1)%7==0) hace que cada domingo se cierre la fila (</tr>) y comience otra
    }
//Recorre todos los días del mes y crea un <button> dentro de <td> para cada día
    html += "</tr></table>";
    calendarioDiv.innerHTML = html;
}

generarCalendario(mes, anio);//Llama a la función al inicio para mostrar el calendario del mes actual


//para navegar entre los meses
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
//Detecta clics en los botones “Mes anterior” y “Mes siguiente”, actualiza mes y año según corresponda, llama de nuevo a generarCalendario() para redibujar la tabla con el nuevo mes

