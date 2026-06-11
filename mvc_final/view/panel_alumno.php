<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi Portal — SENATI</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
    --azul:#1A2B5F;--azul2:#2A4494;--naranja:#F28C28;
    --verde:#27ae60;--gris:#f0f4f8;--card:#fff;--borde:#e1e8ed;
}
body{font-family:'Sora',sans-serif;background:var(--gris);min-height:100vh;display:flex;flex-direction:column;}

/* TOP BAR */
.topbar{
    background:linear-gradient(90deg,var(--azul) 0%,var(--azul2) 100%);
    color:#fff;padding:0 32px;
    display:flex;justify-content:space-between;align-items:center;
    height:64px;box-shadow:0 2px 12px rgba(0,0,0,.15);
}
.topbar .brand{font-size:18px;font-weight:800;letter-spacing:-0.5px;}
.topbar .brand span{color:var(--naranja);}
.topbar nav{display:flex;align-items:center;gap:6px;}
.topbar nav a{color:rgba(255,255,255,.8);text-decoration:none;padding:8px 14px;
              border-radius:8px;font-size:13px;font-weight:600;transition:all .2s;}
.topbar nav a:hover{background:rgba(255,255,255,.1);color:#fff;}
.topbar nav a.logout{background:rgba(231,76,60,.8);color:#fff;margin-left:8px;}
.topbar nav a.logout:hover{background:#e74c3c;}

/* HERO */
.hero{
    background:linear-gradient(135deg,var(--azul) 0%,var(--azul2) 100%);
    padding:36px 40px 60px;color:#fff;position:relative;overflow:hidden;
}
.hero::after{
    content:'';position:absolute;right:-80px;top:-80px;
    width:300px;height:300px;border-radius:50%;
    background:rgba(242,140,40,.1);
}
.hero::before{
    content:'';position:absolute;right:80px;bottom:-100px;
    width:200px;height:200px;border-radius:50%;
    background:rgba(255,255,255,.05);
}
.hero .greeting{font-size:13px;font-weight:600;color:rgba(255,255,255,.6);margin-bottom:8px;letter-spacing:1px;text-transform:uppercase;}
.hero h1{font-size:28px;font-weight:800;letter-spacing:-0.5px;}
.hero h1 span{color:var(--naranja);}
.hero .meta{display:flex;gap:20px;margin-top:20px;flex-wrap:wrap;}
.meta-pill{
    background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
    padding:8px 18px;border-radius:20px;font-size:12px;font-weight:600;
    display:flex;align-items:center;gap:6px;
}

/* CONTENT */
.content{max-width:1100px;margin:0 auto;padding:30px 32px;flex:1;width:100%;}

/* CARDS MI PERFIL */
.profile-grid{display:grid;grid-template-columns:1fr 2fr;gap:20px;margin-bottom:28px;}
.profile-card{
    background:var(--card);border-radius:16px;padding:28px;
    border:1px solid var(--borde);
    display:flex;flex-direction:column;align-items:center;text-align:center;
}
.profile-avatar{
    width:80px;height:80px;border-radius:50%;
    background:linear-gradient(135deg,var(--azul),var(--azul2));
    display:flex;align-items:center;justify-content:center;
    font-size:32px;color:#fff;margin-bottom:16px;
    box-shadow:0 4px 12px rgba(26,43,95,.25);
}
.profile-card .name{font-size:16px;font-weight:800;color:var(--azul);margin-bottom:4px;}
.profile-card .role-badge{
    background:#e8eef8;color:var(--azul);
    padding:4px 12px;border-radius:12px;font-size:11px;font-weight:700;
    margin-bottom:14px;
}
.profile-data{width:100%;}
.data-row{display:flex;justify-content:space-between;align-items:center;
          padding:8px 0;border-bottom:1px solid var(--gris);font-size:13px;}
.data-row:last-child{border-bottom:none;}
.data-row .lbl{color:#888;font-weight:600;}
.data-row .val{color:var(--azul);font-weight:700;}

.info-card{background:var(--card);border-radius:16px;padding:28px;border:1px solid var(--borde);}
.info-card h3{font-size:15px;font-weight:800;color:var(--azul);margin-bottom:20px;
              text-transform:uppercase;letter-spacing:.5px;}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.info-item{background:var(--gris);border-radius:10px;padding:16px;}
.info-item .lbl{font-size:11px;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;}
.info-item .val{font-size:14px;font-weight:700;color:var(--azul);}

/* AVISO SOLO LECTURA */
.aviso-readonly{
    background:#fff8e8;border:1px solid #ffd47a;border-left:4px solid var(--naranja);
    border-radius:12px;padding:14px 20px;margin-bottom:24px;
    display:flex;align-items:center;gap:12px;font-size:13px;color:#7a4f00;
}
.aviso-readonly strong{font-weight:700;}

/* BUSCADORES */
.search-row{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px;}
.search-card{background:var(--card);border-radius:14px;padding:24px;border:1px solid var(--borde);}
.search-card h3{font-size:13px;font-weight:700;color:var(--azul);margin-bottom:14px;
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
           line-height:1.8;display:none;}
.resultado.ok{background:#e8f1fc;border-left:4px solid var(--azul);}
.resultado.err{background:#fde8e8;border-left:4px solid #e74c3c;}
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
    border-top:3px solid var(--naranja);margin-top:auto;
}
@media(max-width:768px){
    .profile-grid,.info-grid,.search-row{grid-template-columns:1fr;}
    .hero{padding:24px 20px 40px;}
    .content{padding:20px 16px;}
}
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
    <span class="brand">SENATI<span>.</span></span>
    <nav>
        <a href="ajax/ajax_libros.php" style="display:none"></a>
        <a href="index.php?accion=logout" class="logout">🚪 Cerrar sesión</a>
    </nav>
</div>

<!-- HERO -->
<div class="hero">
    <p class="greeting">Portal del Estudiante</p>
    <h1>Hola, <span><?php echo htmlspecialchars($alumno['nombre']); ?></span> 👋</h1>
    <div class="meta">
        <div class="meta-pill">🪪 ID: <?php echo htmlspecialchars($alumno['id_estudiante']); ?></div>
        <div class="meta-pill">📧 <?php echo htmlspecialchars($alumno['correo']); ?></div>
        <div class="meta-pill">🎓 Estudiante SENATI</div>
    </div>
</div>

<div class="content">

    <!-- AVISO -->
    <div class="aviso-readonly">
        <span style="font-size:20px">ℹ️</span>
        <div>
            <strong>Modo solo lectura:</strong> Como alumno, puedes consultar información de la biblioteca y buscar compañeros.
            Para modificar tus datos personales, contacta a un administrador.
        </div>
    </div>

    <!-- PERFIL + INFO -->
    <div class="profile-grid">
        <div class="profile-card">
            <div class="profile-avatar">
                <?php echo strtoupper(substr($alumno['nombre'],0,1)); ?>
            </div>
            <div class="name"><?php echo htmlspecialchars($alumno['nombre'].' '.$alumno['apellidos']); ?></div>
            <div class="role-badge">👨‍🎓 Alumno</div>
            <div class="profile-data">
                <div class="data-row">
                    <span class="lbl">ID Estudiante</span>
                    <span class="val"><?php echo htmlspecialchars($alumno['id_estudiante']); ?></span>
                </div>
                <div class="data-row">
                    <span class="lbl">Correo</span>
                    <span class="val" style="font-size:11px"><?php echo htmlspecialchars($alumno['correo']); ?></span>
                </div>
            </div>
        </div>

        <div class="info-card">
            <h3>📋 Información académica</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="lbl">Nombre completo</div>
                    <div class="val"><?php echo htmlspecialchars($alumno['nombre'].' '.$alumno['apellidos']); ?></div>
                </div>
                <div class="info-item">
                    <div class="lbl">ID de Estudiante</div>
                    <div class="val"><?php echo htmlspecialchars($alumno['id_estudiante']); ?></div>
                </div>
                <div class="info-item">
                    <div class="lbl">Correo institucional</div>
                    <div class="val" style="font-size:12px"><?php echo htmlspecialchars($alumno['correo']); ?></div>
                </div>
                <div class="info-item">
                    <div class="lbl">Estado de cuenta</div>
                    <div class="val" style="color:var(--verde)">✅ Activo</div>
                </div>
            </div>
        </div>
    </div>

    <!-- BUSCADORES -->
    <div class="search-row">
        <div class="search-card">
            <h3>🔍 Consultar Libro</h3>
            <div class="inp-row">
                <input type="text" id="inp-libro" placeholder="Título del libro...">
                <button onclick="buscarLibro()">Buscar</button>
                <div class="spin" id="spin-libro"></div>
            </div>
            <div class="resultado" id="res-libro"></div>
        </div>
        <div class="search-card">
            <h3>🔍 Buscar Compañero</h3>
            <div class="inp-row">
                <input type="text" id="inp-alumno" placeholder="ID o nombre...">
                <button onclick="buscarAlumno()">Buscar</button>
                <div class="spin" id="spin-alumno"></div>
            </div>
            <div class="resultado" id="res-alumno"></div>
        </div>
    </div>

</div>

<footer class="footer">
    © <?php echo date('Y'); ?> SENATI Huánuco · Portal del Estudiante · Sistema académico interno
</footer>

<script>
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
</script>
</body>
</html>
