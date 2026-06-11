<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Administrador — SENATI</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
    --azul:#1A2B5F;--azul2:#2A4494;--naranja:#F28C28;
    --verde:#2ecc71;--rojo:#e74c3c;--gris:#f0f4f8;
    --card:#fff;--borde:#e1e8ed;
}
body{font-family:'Sora',sans-serif;background:var(--gris);min-height:100vh;display:flex;flex-direction:column;}

/* SIDEBAR */
.sidebar{
    position:fixed;top:0;left:0;width:240px;height:100vh;
    background:var(--azul);
    display:flex;flex-direction:column;
    z-index:100;
    box-shadow:4px 0 20px rgba(0,0,0,.2);
}
.sidebar-brand{
    padding:28px 24px 20px;
    border-bottom:1px solid rgba(255,255,255,.1);
}
.sidebar-brand .logo{font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px;}
.sidebar-brand .logo span{color:var(--naranja);}
.sidebar-brand .badge-admin{
    display:inline-block;background:var(--naranja);color:#fff;
    font-size:10px;font-weight:700;padding:2px 10px;border-radius:20px;
    letter-spacing:1px;margin-top:6px;
}
.sidebar-nav{flex:1;padding:16px 0;}
.nav-section{
    font-size:10px;font-weight:700;color:rgba(255,255,255,.35);
    letter-spacing:2px;padding:16px 24px 8px;text-transform:uppercase;
}
.nav-link{
    display:flex;align-items:center;gap:12px;
    padding:12px 24px;color:rgba(255,255,255,.75);
    text-decoration:none;font-size:13px;font-weight:600;
    transition:all .2s;border-left:3px solid transparent;
}
.nav-link:hover,.nav-link.active{
    color:#fff;background:rgba(255,255,255,.08);
    border-left-color:var(--naranja);
}
.nav-link .ico{font-size:17px;width:22px;text-align:center;}
.sidebar-user{
    padding:20px 24px;border-top:1px solid rgba(255,255,255,.1);
    font-size:12px;color:rgba(255,255,255,.55);
}
.sidebar-user strong{display:block;color:#fff;font-size:13px;margin-bottom:2px;}
.sidebar-user a{
    display:inline-block;margin-top:10px;background:var(--rojo);
    color:#fff;padding:7px 14px;border-radius:7px;
    font-size:12px;font-weight:700;text-decoration:none;transition:background .2s;
}
.sidebar-user a:hover{background:#c0392b;}

/* MAIN */
.main{margin-left:240px;flex:1;display:flex;flex-direction:column;}
.topbar-inner{
    background:#fff;padding:18px 32px;
    display:flex;justify-content:space-between;align-items:center;
    border-bottom:1px solid var(--borde);
    box-shadow:0 2px 8px rgba(0,0,0,.04);
}
.topbar-inner h1{font-size:20px;font-weight:800;color:var(--azul);}
.topbar-inner .sub{font-size:13px;color:#888;margin-top:2px;}
.time-badge{
    background:var(--gris);border:1px solid var(--borde);
    border-radius:8px;padding:8px 16px;font-size:12px;
    color:#666;font-weight:600;
}

.content{padding:28px 32px;flex:1;}

/* STAT CARDS */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:28px;}
.stat-card{
    background:var(--card);border-radius:14px;padding:22px 24px;
    border:1px solid var(--borde);
    display:flex;align-items:center;gap:16px;
    transition:transform .2s,box-shadow .2s;
}
.stat-card:hover{transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,.08);}
.stat-icon{
    width:52px;height:52px;border-radius:14px;
    display:flex;align-items:center;justify-content:center;font-size:22px;
}
.stat-icon.azul{background:#e8eef8;}
.stat-icon.naranja{background:#fef3e6;}
.stat-icon.verde{background:#e9f7ef;}
.stat-icon.rojo{background:#fde8e8;}
.stat-info .num{font-size:26px;font-weight:800;color:var(--azul);}
.stat-info .lbl{font-size:12px;color:#888;font-weight:600;margin-top:2px;}

/* QUICK ACTIONS */
.quick-actions{
    display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px;
}
.qa-card{
    background:var(--card);border-radius:14px;padding:22px;
    border:1px solid var(--borde);text-decoration:none;
    display:flex;align-items:center;gap:16px;
    transition:all .25s;
}
.qa-card:hover{border-color:var(--naranja);transform:translateY(-3px);box-shadow:0 8px 20px rgba(0,0,0,.08);}
.qa-card .qa-ico{font-size:28px;}
.qa-card .qa-txt strong{display:block;color:var(--azul);font-size:14px;font-weight:700;}
.qa-card .qa-txt span{font-size:12px;color:#888;}

/* CHARTS */
.charts-row{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px;}
.chart-card{
    background:var(--card);border-radius:14px;padding:24px;
    border:1px solid var(--borde);
}
.chart-card h3{font-size:14px;font-weight:700;color:var(--azul);margin-bottom:18px;
               text-transform:uppercase;letter-spacing:.5px;}
.chart-wrap{height:260px;position:relative;}

/* SEARCH */
.search-row{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px;}
.search-card{background:var(--card);border-radius:14px;padding:24px;border:1px solid var(--borde);}
.search-card h3{font-size:14px;font-weight:700;color:var(--azul);margin-bottom:14px;
                text-transform:uppercase;letter-spacing:.5px;}
.inp-row{display:flex;gap:8px;}
.inp-row input{flex:1;padding:10px 14px;border:2px solid var(--borde);border-radius:9px;
               font-size:13px;font-family:'Sora',sans-serif;transition:border-color .2s;}
.inp-row input:focus{outline:none;border-color:var(--azul);}
.inp-row button{padding:10px 16px;background:var(--azul);color:#fff;border:none;
                border-radius:9px;cursor:pointer;font-size:13px;font-weight:700;
                font-family:'Sora',sans-serif;transition:background .2s;}
.inp-row button:hover{background:var(--naranja);}
.resultado{margin-top:14px;padding:14px;border-radius:9px;font-size:13px;
           line-height:1.8;display:none;animation:fadeUp .3s ease;}
@keyframes fadeUp{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
.resultado.ok{background:#e8f1fc;border-left:4px solid var(--azul);}
.resultado.err{background:#fde8e8;border-left:4px solid var(--rojo);}
.badge-disp{background:#d4edda;color:#155724;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700;}
.badge-pres{background:#fde8e8;color:#721c24;padding:2px 10px;border-radius:12px;font-size:11px;font-weight:700;}
.spin{display:none;width:16px;height:16px;border:2px solid #eee;
      border-top-color:var(--naranja);border-radius:50%;
      animation:giro .7s linear infinite;vertical-align:middle;}
@keyframes giro{to{transform:rotate(360deg)}}

/* FOOTER */
.footer{
    background:var(--azul);color:rgba(255,255,255,.5);
    text-align:center;padding:16px;font-size:12px;
    border-top:3px solid var(--naranja);
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">SENATI<span>.</span></div>
        <span class="badge-admin">⚡ ADMINISTRADOR</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Principal</div>
        <a href="index.php?accion=panel" class="nav-link active">
            <span class="ico">📊</span> Dashboard
        </a>
        <div class="nav-section">Gestión</div>
        <a href="index.php?accion=alumnos" class="nav-link">
            <span class="ico">👨‍🎓</span> Alumnos
        </a>
        <a href="index.php?accion=alumnos_crear" class="nav-link">
            <span class="ico">➕</span> Nuevo Alumno
        </a>
        <a href="index.php?accion=libros" class="nav-link">
            <span class="ico">📚</span> Libros
        </a>
        <a href="index.php?accion=libros_crear" class="nav-link">
            <span class="ico">📖</span> Nuevo Libro
        </a>
        <div class="nav-section">Reportes</div>
        <a href="reporte/reporte_pdf.php" class="nav-link" id="btn-pdf-link">
            <span class="ico">📄</span> Exportar PDF
        </a>
    </nav>
    <div class="sidebar-user">
        <strong><?php echo htmlspecialchars($alumno['nombre'].' '.$alumno['apellidos']); ?></strong>
        <?php echo htmlspecialchars($alumno['correo']); ?>
        <br>
        <a href="index.php?accion=logout">🚪 Cerrar sesión</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">
    <div class="topbar-inner">
        <div>
            <h1>Panel de Administración</h1>
            <div class="sub">Control total del sistema SENATI</div>
        </div>
        <div class="time-badge" id="reloj">—</div>
    </div>

    <div class="content">

        <!-- ESTADÍSTICAS -->
        <div class="stats" id="stats-container">
            <div class="stat-card">
                <div class="stat-icon azul">👨‍🎓</div>
                <div class="stat-info">
                    <div class="num" id="stat-alumnos">—</div>
                    <div class="lbl">Alumnos activos</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon naranja">📚</div>
                <div class="stat-info">
                    <div class="num" id="stat-libros">—</div>
                    <div class="lbl">Libros en biblioteca</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon verde">✅</div>
                <div class="stat-info">
                    <div class="num" id="stat-disponibles">—</div>
                    <div class="lbl">Libros disponibles</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon rojo">🔴</div>
                <div class="stat-info">
                    <div class="num" id="stat-inactivos">—</div>
                    <div class="lbl">Alumnos inactivos</div>
                </div>
            </div>
        </div>

        <!-- ACCIONES RÁPIDAS -->
        <div class="quick-actions">
            <a href="index.php?accion=alumnos_crear" class="qa-card">
                <span class="qa-ico">👤➕</span>
                <div class="qa-txt">
                    <strong>Registrar Alumno</strong>
                    <span>Añadir nuevo estudiante al sistema</span>
                </div>
            </a>
            <a href="index.php?accion=libros_crear" class="qa-card">
                <span class="qa-ico">📖➕</span>
                <div class="qa-txt">
                    <strong>Agregar Libro</strong>
                    <span>Añadir libro a la biblioteca</span>
                </div>
            </a>
            <a href="reporte/reporte_pdf.php" class="qa-card" id="qa-pdf">
                <span class="qa-ico">📊</span>
                <div class="qa-txt">
                    <strong>Generar Reporte PDF</strong>
                    <span>Exportar estadísticas completas</span>
                </div>
            </a>
        </div>

        <!-- BUSCADORES -->
        <div class="search-row">
            <div class="search-card">
                <h3>🔍 Buscar Libro</h3>
                <div class="inp-row">
                    <input type="text" id="inp-libro" placeholder="Título del libro...">
                    <button onclick="buscarLibro()">Buscar</button>
                    <div class="spin" id="spin-libro"></div>
                </div>
                <div class="resultado" id="res-libro"></div>
            </div>
            <div class="search-card">
                <h3>🔍 Buscar Alumno</h3>
                <div class="inp-row">
                    <input type="text" id="inp-alumno" placeholder="ID o nombre del alumno...">
                    <button onclick="buscarAlumno()">Buscar</button>
                    <div class="spin" id="spin-alumno"></div>
                </div>
                <div class="resultado" id="res-alumno"></div>
            </div>
        </div>

        <!-- GRÁFICAS -->
        <div class="charts-row">
            <div class="chart-card">
                <h3>📚 Libros por Estado</h3>
                <div class="chart-wrap"><canvas id="grafica-libros"></canvas></div>
            </div>
            <div class="chart-card">
                <h3>🎓 Alumnos por Carrera</h3>
                <div class="chart-wrap"><canvas id="grafica-alumnos"></canvas></div>
            </div>
        </div>

    </div><!-- /content -->

    <footer class="footer">
        © <?php echo date('Y'); ?> SENATI Huánuco · Panel de Administración · Sistema académico interno
    </footer>
</div>

<script>
// Reloj
function tickReloj(){
    const now=new Date();
    document.getElementById('reloj').textContent=
        now.toLocaleDateString('es-PE',{weekday:'short',day:'2-digit',month:'short'})+
        ' · '+now.toLocaleTimeString('es-PE',{hour:'2-digit',minute:'2-digit'});
}
tickReloj(); setInterval(tickReloj,30000);

// Estadísticas desde la API de gráficas
fetch('ajax/datos_graficas.php').then(x=>x.json()).then(data=>{
    if(data.error){ console.error(data.error); return; }

    // Totales simulados desde datos de gráficas
    const totalLibros = data.libros.data.reduce((a,b)=>a+b,0);
    const disponibles = data.libros.data[0]||0;
    document.getElementById('stat-libros').textContent=totalLibros;
    document.getElementById('stat-disponibles').textContent=disponibles;

    Chart.defaults.font.family="'Sora',sans-serif";
    Chart.defaults.color='#4a5568';

    new Chart(document.getElementById('grafica-libros'),{
        type:'bar',
        data:{
            labels:data.libros.labels,
            datasets:[{
                label:'Cantidad',data:data.libros.data,
                backgroundColor:'#1A2B5F',hoverBackgroundColor:'#F28C28',
                borderRadius:8,barPercentage:.55
            }]
        },
        options:{responsive:true,maintainAspectRatio:false,
            plugins:{legend:{display:false},
                tooltip:{backgroundColor:'rgba(26,43,95,.95)',padding:12,cornerRadius:8,displayColors:false}},
            scales:{y:{beginAtZero:true,ticks:{stepSize:1},grid:{color:'#e2e8f0',borderDash:[4,4]}},
                    x:{grid:{display:false}}}}
    });

    new Chart(document.getElementById('grafica-alumnos'),{
        type:'doughnut',
        data:{
            labels:data.alumnos.labels,
            datasets:[{data:data.alumnos.data,
                backgroundColor:['#1A2B5F','#F28C28','#2ecc71','#e74c3c','#9b59b6','#f1c40f','#1abc9c'],
                borderWidth:3,borderColor:'#fff',hoverOffset:10}]
        },
        options:{responsive:true,maintainAspectRatio:false,
            plugins:{legend:{position:'right',labels:{usePointStyle:true,padding:14,font:{size:11,weight:'700'}}},
                tooltip:{backgroundColor:'rgba(26,43,95,.95)',padding:12,cornerRadius:8}}}
    });

}).catch(e=>console.error('Graficas:',e));

// Cargar alumnos activos e inactivos
fetch('ajax/ajax_stats.php').then(x=>x.json()).then(d=>{
    if(d.activos!==undefined) document.getElementById('stat-alumnos').textContent=d.activos;
    if(d.inactivos!==undefined) document.getElementById('stat-inactivos').textContent=d.inactivos;
}).catch(()=>{});

// Buscadores
function buscarLibro(){
    const v=document.getElementById('inp-libro').value.trim();
    const r=document.getElementById('res-libro');
    const s=document.getElementById('spin-libro');
    if(!v){show(r,'err','Ingresa un título.');return;}
    s.style.display='inline-block';r.style.display='none';
    fetch('ajax/ajax_libros.php?titulo='+encodeURIComponent(v))
    .then(x=>x.json()).then(d=>{
        s.style.display='none';
        if(d.error||!d.encontrado){show(r,'err',d.error||d.mensaje);return;}
        const b=d.estado.toLowerCase()==='disponible'
            ?'<span class="badge-disp">Disponible</span>'
            :'<span class="badge-pres">Prestado</span>';
        show(r,'ok','<b>Título:</b> '+e(d.titulo)+'<br><b>Autor:</b> '+e(d.autor)+'<br><b>Estado:</b> '+b);
    }).catch(()=>{s.style.display='none';show(r,'err','Error de conexión.');});
}
function buscarAlumno(){
    const v=document.getElementById('inp-alumno').value.trim();
    const r=document.getElementById('res-alumno');
    const s=document.getElementById('spin-alumno');
    if(!v){show(r,'err','Ingresa un ID o nombre.');return;}
    s.style.display='inline-block';r.style.display='none';
    fetch('ajax/ajax_alumnos.php?q='+encodeURIComponent(v))
    .then(x=>x.json()).then(d=>{
        s.style.display='none';
        if(d.error||!d.encontrado){show(r,'err',d.error||d.mensaje);return;}
        show(r,'ok','<b>ID:</b> '+e(d.id_estudiante)+'<br><b>Nombre:</b> '+e(d.nombre+' '+d.apellidos)+'<br><b>Correo:</b> '+e(d.correo)+'<br><b>Carrera:</b> '+e(d.carrera));
    }).catch(()=>{s.style.display='none';show(r,'err','Error de conexión.');});
}
function show(el,cls,html){el.className='resultado '+cls;el.innerHTML=html;el.style.display='block';}
function e(s){const d=document.createElement('div');d.appendChild(document.createTextNode(String(s)));return d.innerHTML;}
document.getElementById('inp-libro').addEventListener('keypress',ev=>{if(ev.key==='Enter')buscarLibro();});
document.getElementById('inp-alumno').addEventListener('keypress',ev=>{if(ev.key==='Enter')buscarAlumno();});

// PDF con gráficas
document.getElementById('qa-pdf').addEventListener('click',function(ev){
    // Permitir comportamiento normal
});
</script>
</body>
</html>
