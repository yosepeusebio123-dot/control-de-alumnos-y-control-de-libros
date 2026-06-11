<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel — SENATI</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
*{box-sizing:border-box;margin:0;padding:0}

body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: #f4f7f6;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.topbar{background: linear-gradient(90deg, #1A2B5F 0%, #2A4494 100%);color:#fff;padding:16px 28px;display:flex;
        justify-content:space-between;align-items:center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);}
.topbar .marca{font-weight:700;font-size:16px; letter-spacing: 0.5px;}
.topbar a{color:#fff;text-decoration:none;margin-left:18px;font-size:13px; font-weight: 600; transition: color 0.3s;}
.topbar a:hover:not(.logout){color: #F28C28;}
.topbar a.logout{background:#e74c3c;padding:8px 16px;border-radius:6px; transition: background 0.3s, transform 0.2s;}
.topbar a.logout:hover{background:#c0392b; transform: scale(1.05);}

.wrap{max-width:1150px;margin:35px auto;padding:0 20px;flex:1;width:100%}

.saludo{color:#1A2B5F;font-size:22px;font-weight:800;margin-bottom:24px; letter-spacing: -0.5px;}

.menu-crud{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:30px}
.menu-crud a{padding:12px 24px;border-radius:8px;font-size:14px;
             font-weight:700;text-decoration:none; transition: all 0.3s ease; box-shadow: 0 4px 6px rgba(0,0,0,0.1);}
.menu-crud a:hover{transform: translateY(-3px); box-shadow: 0 6px 12px rgba(0,0,0,0.15);}
.btn-libros {background:#1A2B5F;color:#fff}
.btn-alumnos{background:#F28C28;color:#fff}
.btn-pdf    {background:#2ecc71;color:#fff}

.buscadores{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:30px}

.card{
    background:#fff;
    border-radius:12px;
    padding:26px 30px;
    box-shadow:0 4px 10px rgba(0,0,0,.04);
    border: 1px solid #e1e8ed;
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}
.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0,0,0,.08);
    border-color: #1A2B5F;
}

.card h3{color:#1A2B5F;font-size:16px;font-weight:800;margin-bottom:16px; text-transform: uppercase; letter-spacing: 0.5px;}

.input-row{display:flex;gap:10px}
.input-row input{flex:1;padding:10px 15px;border:2px solid #e1e8ed;
                 border-radius:8px;font-size:14px; transition: border-color 0.3s;}
.input-row input:focus{outline:none;border-color:#1A2B5F;}
.input-row button{padding:10px 18px;background:#1A2B5F;color:#fff;
                  border:none;border-radius:8px;cursor:pointer;font-size:14px;font-weight:700;
                  transition: background 0.3s, transform 0.2s;}
.input-row button:hover{background:#F28C28; transform: translateY(-2px);}
.input-row button:active{transform: translateY(0);}

.resultado{margin-top:16px;padding:14px 18px;border-radius:8px;
           font-size:14px;line-height:1.9;display:none; animation: fadeIn 0.4s ease;}
@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
.resultado.ok{background:#e8f4fd;border-left:5px solid #1A2B5F; color: #0d1b3e;}
.resultado.err{background:#fde8e8;border-left:5px solid #e74c3c;color:#990000;}

.badge{display:inline-block;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:800; text-transform: uppercase;}
.disp{background:#d4edda;color:#155724; border: 1px solid #c3e6cb;}
.pres{background:#f8d7da;color:#721c24; border: 1px solid #f5c6cb;}

.spin{display:none;width:18px;height:18px;border:3px solid #f3f3f3;
      border-top-color:#F28C28;border-radius:50%;
      animation:giro .8s linear infinite;vertical-align:middle; margin-left: 8px;}
@keyframes giro{to{transform:rotate(360deg)}}

.graficas{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.chart-wrap{position:relative;height:280px; width: 100%;}

/* FOOTER MODERNO */
.footer {
    background-color: #1A2B5F;
    color: #ffffff;
    padding: 45px 0;
    margin-top: 50px;
    border-top: 4px solid #F28C28; /* Detalle de color corporativo superior */
}

.footer-content {
    max-width: 1150px; /* Mantiene la misma alineación que la clase .wrap */
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 30px;
}

.footer-izq {
    text-align: left;
    max-width: 400px;
}

.footer-izq h4 {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 12px;
    letter-spacing: 0.5px;
    color: #ffffff;
}

.footer-izq p {
    font-size: 14px;
    color: #b3c0e7;
    line-height: 1.6;
    margin-bottom: 8px;
}

.footer-izq .copy {
    font-size: 13px;
    opacity: 0.7;
    margin-top: 20px;
}

.footer-der {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}

.footer-col {
    display: flex;
    flex-direction: column;
    gap: 12px;
    text-align: left;
}

.footer-col span {
    font-weight: 700;
    font-size: 15px;
    color: #F28C28;
    margin-bottom: 5px;
}

.footer-col a {
    color: #b3c0e7;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: color 0.3s ease, transform 0.3s ease;
}

.footer-col a:hover {
    color: #ffffff;
    transform: translateX(3px); /* Pequeño salto a la derecha al hacer hover */
}

/* Responsive básico para pantallas pequeñas */
@media (max-width: 768px) {
    .buscadores, .graficas { grid-template-columns: 1fr; }
    .topbar { flex-direction: column; gap: 15px; }
    .topbar div { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
    .topbar a { margin-left: 0; }
    
    .footer-content { flex-direction: column; }
    .footer-der { width: 100%; justify-content: space-between; gap: 20px; }
}
</style>
</head>
<body>

<div class="topbar">
  <span class="marca">Intranet SENATI</span>
  <div>
    <a href="index.php?accion=libros">Libros</a>
    <a href="index.php?accion=alumnos">Alumnos</a>
    <a href="index.php?accion=logout" class="logout">Cerrar sesión</a>
  </div>
</div>

<div class="wrap">
  <p class="saludo">Bienvenido(a),
    <?php echo htmlspecialchars($alumno['nombre'].' '.$alumno['apellidos']); ?>
  </p>

  <!-- MENU CRUD -->
  <div class="menu-crud">
    <a href="index.php?accion=libros"  class="btn-libros">  Gestionar Libros  </a>
    <a href="index.php?accion=alumnos" class="btn-alumnos"> Gestionar Alumnos </a>
    <a href="reporte/reporte_pdf.php"  class="btn-pdf"
       id="btn-pdf" onclick="exportarPDF(event)">Exportar PDF</a>
  </div>

  <!-- BUSCADORES AJAX -->
  <div class="buscadores">
    <div class="card">
      <h3>Buscar libro</h3>
      <div class="input-row">
        <input type="text" id="inp-libro" placeholder="Título del libro...">
        <button onclick="buscarLibro()">Buscar</button>
        <div class="spin" id="spin-libro"></div>
      </div>
      <div class="resultado" id="res-libro"></div>
    </div>
    <div class="card">
      <h3>Buscar alumno</h3>
      <div class="input-row">
        <input type="text" id="inp-alumno" placeholder="ID o nombre del alumno...">
        <button onclick="buscarAlumno()">Buscar</button>
        <div class="spin" id="spin-alumno"></div>
      </div>
      <div class="resultado" id="res-alumno"></div>
    </div>
  </div>

  <!-- GRAFICAS -->
  <div class="graficas">
    <div class="card">
      <h3>Cantidad de Libros</h3>
      <div class="chart-wrap"><canvas id="grafica-libros"></canvas></div>
    </div>
    <div class="card">
      <h3>Alumnos por Carrera</h3>
      <div class="chart-wrap"><canvas id="grafica-alumnos"></canvas></div>
    </div>
  </div>
</div>

<!-- FOOTER MODERNO -->
<footer class="footer"> 
    <div class="footer-content">
        <!-- Lado Izquierdo: Marca e Información -->
        <div class="footer-izq">
            <h4>Intranet SENATI</h4>
            <p>Sistema interno para la visualización de estadísticas de alumnos y gestión de bibliotecas.</p>
            <p class="copy">&copy; 2026 yosep EM. Todos los derechos reservados.</p>
           
        </div>
        
        <!-- Lado Derecho: Enlaces en Columnas -->
        <div class="footer-der">
            <div class="footer-col">
                <span>Institución</span>
                <a href="/sobre-nosotros">Sobre nosotros</a>
                <a href="/direccion">Ubicación y Sedes</a>
            </div>
            <div class="footer-col">
                <span>Soporte</span>
                <a href="/contacto">Contacto</a>
                <a href="/privacidad">Políticas de Privacidad</a>
            </div>
        </div>
    </div>
</footer>

<script>
let chartLibros = null, chartAlumnos = null;

function buscarLibro() {
    const v = document.getElementById('inp-libro').value.trim();
    const r = document.getElementById('res-libro');
    const s = document.getElementById('spin-libro');
    if (!v) { show(r,'err','Ingresa un título.'); return; }
    s.style.display='inline-block'; r.style.display='none';
    fetch('ajax/ajax_libros.php?titulo='+encodeURIComponent(v))
    .then(x=>x.json()).then(d=>{
        s.style.display='none';
        if(d.error){show(r,'err',d.error);return;}
        if(!d.encontrado){show(r,'err',d.mensaje);return;}
        const b=d.estado.toLowerCase()==='disponible'
            ?'<span class="badge disp">Disponible</span>'
            :'<span class="badge pres">Prestado</span>';
        show(r,'ok','<b>Título:</b> '+e(d.titulo)+'<br><b>Autor:</b> '+e(d.autor)+'<br><b>Estado:</b> '+b);
    }).catch(()=>{s.style.display='none';show(r,'err','Error de conexión.');});
}

function buscarAlumno() {
    const v = document.getElementById('inp-alumno').value.trim();
    const r = document.getElementById('res-alumno');
    const s = document.getElementById('spin-alumno');
    if (!v) { show(r,'err','Ingresa un ID o nombre.'); return; }
    s.style.display='inline-block'; r.style.display='none';
    fetch('ajax/ajax_alumnos.php?q='+encodeURIComponent(v))
    .then(x=>x.json()).then(d=>{
        s.style.display='none';
        if(d.error){show(r,'err',d.error);return;}
        if(!d.encontrado){show(r,'err',d.mensaje);return;}
        show(r,'ok',
            '<b>ID:</b> '+e(d.id_estudiante)+'<br>'+
            '<b>Nombre:</b> '+e(d.nombre+' '+d.apellidos)+'<br>'+
            '<b>Correo:</b> '+e(d.correo)+'<br>'+
            '<b>Carrera:</b> '+e(d.carrera));
    }).catch(()=>{s.style.display='none';show(r,'err','Error de conexión.');});
}

function show(el,cls,html){el.className='resultado '+cls;el.innerHTML=html;el.style.display='block';}
function e(s){const d=document.createElement('div');d.appendChild(document.createTextNode(String(s)));return d.innerHTML;}

document.getElementById('inp-libro').addEventListener('keypress',ev=>{if(ev.key==='Enter')buscarLibro();});
document.getElementById('inp-alumno').addEventListener('keypress',ev=>{if(ev.key==='Enter')buscarAlumno();});

function exportarPDF(ev) {
    ev.preventDefault();
    const f=document.createElement('form');
    f.method='POST';f.action='reporte/reporte_pdf.php';f.target='_blank';
    [['img_libros',chartLibros?chartLibros.toBase64Image():''],
     ['img_alumnos',chartAlumnos?chartAlumnos.toBase64Image():'']].forEach(([n,v])=>{
        const i=document.createElement('input');i.type='hidden';i.name=n;i.value=v;f.appendChild(i);});
    document.body.appendChild(f);f.submit();document.body.removeChild(f);
}

// Cargar graficas
fetch('ajax/datos_graficas.php').then(x=>x.json()).then(data=>{
    if(data.error){console.error(data.error);return;}
    
    Chart.defaults.font.family = "'Segoe UI', Tahoma, sans-serif";
    Chart.defaults.color = '#4a5568';

    // 1. GRAFICO DE LIBROS (BARRAS ACTIVAS)
    chartLibros = new Chart(document.getElementById('grafica-libros'), {
        type: 'bar',
        data: {
            labels: data.libros.labels,
            datasets: [{
                label: 'Cantidad',
                data: data.libros.data,
                backgroundColor: '#1A2B5F',
                hoverBackgroundColor: '#F28C28',
                borderColor: 'transparent',
                hoverBorderColor: '#1A2B5F',
                hoverBorderWidth: 2,
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 1200, easing: 'easeOutQuart' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(26, 43, 95, 0.95)',
                    padding: 14,
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 13 },
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, padding: 10, font: {weight: '600'} },
                    grid: { color: '#e2e8f0', borderDash: [4, 4], drawBorder: false }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { font: { weight: 'bold' } }
                }
            }
        }
    });

    // 2. GRAFICO DE ALUMNOS (TORTA ACTIVA)
    chartAlumnos = new Chart(document.getElementById('grafica-alumnos'), {
        type: 'pie',
        data: {
            labels: data.alumnos.labels,
            datasets: [{
                data: data.alumnos.data,
                backgroundColor: ['#1A2B5F', '#F28C28', '#2ecc71', '#e74c3c', '#9b59b6', '#f1c40f'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 15
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: 15 },
            animation: { duration: 1500, easing: 'easeOutBounce' },
            plugins: {
                legend: { 
                    position: 'right',
                    labels: { usePointStyle: true, padding: 16, font: { size: 12, weight: '700' } }
                },
                tooltip: {
                    backgroundColor: 'rgba(26, 43, 95, 0.95)',
                    padding: 14,
                    cornerRadius: 8,
                    titleFont: { size: 14 },
                    bodyFont: { size: 14, weight: 'bold' }
                }
            }
        }
    });
}).catch(err=>console.error('Graficas:',err));
</script>
</body>
</html>