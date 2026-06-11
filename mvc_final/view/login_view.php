<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso — SENATI</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --azul:    #1A2B5F;
            --azul2:   #2A4494;
            --naranja: #F28C28;
            --blanco:  #ffffff;
            --gris:    #f0f4f8;
        }
        body {
            font-family: 'Sora', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--azul);
            overflow: hidden;
        }
        /* Panel izquierdo decorativo */
        .deco {
            flex: 1;
            background: linear-gradient(145deg, #0f1c3f 0%, #1A2B5F 50%, #2A4494 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }
        .deco::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            border: 2px solid rgba(242,140,40,0.15);
            top: -100px; left: -150px;
        }
        .deco::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            border: 2px solid rgba(242,140,40,0.1);
            bottom: -50px; right: -80px;
        }
        .deco-logo { font-size: 48px; margin-bottom: 20px; }
        .deco h1 {
            color: #fff;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -1px;
            text-align: center;
        }
        .deco h1 span { color: var(--naranja); }
        .deco p {
            color: rgba(255,255,255,0.55);
            font-size: 14px;
            margin-top: 14px;
            text-align: center;
            max-width: 320px;
            line-height: 1.7;
        }
        .deco .pills {
            display: flex; flex-wrap: wrap; gap: 10px;
            margin-top: 36px; justify-content: center;
        }
        .pill {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.75);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        /* Panel derecho: formulario */
        .login-panel {
            width: 420px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
        }
        .login-panel .tag {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--naranja);
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .login-panel h2 {
            font-size: 26px;
            font-weight: 800;
            color: var(--azul);
            margin-bottom: 6px;
        }
        .login-panel .sub {
            font-size: 13px;
            color: #888;
            margin-bottom: 36px;
        }
        label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: #444;
            margin-bottom: 7px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .input-wrap {
            position: relative;
            margin-bottom: 22px;
        }
        .input-wrap .ico {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #aaa;
        }
        .input-wrap input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            border: 2px solid #e8edf2;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Sora', sans-serif;
            color: #333;
            transition: border-color 0.25s, box-shadow 0.25s;
            background: #fafbfc;
        }
        .input-wrap input:focus {
            outline: none;
            border-color: var(--azul);
            box-shadow: 0 0 0 4px rgba(26,43,95,0.08);
            background: #fff;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--azul);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
            transition: background 0.25s, transform 0.15s;
            margin-top: 6px;
            letter-spacing: 0.3px;
        }
        .btn-login:hover {
            background: var(--naranja);
            transform: translateY(-2px);
        }
        .btn-login:active { transform: translateY(0); }
        .error-box {
            background: #fff1f0;
            border: 1px solid #ffc3c3;
            border-left: 4px solid #e74c3c;
            color: #a00;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .footer-login {
            position: absolute;
            bottom: 28px; left: 0; right: 0;
            text-align: center;
            font-size: 12px;
            color: #bbb;
        }
        @media (max-width: 768px) {
            .deco { display: none; }
            .login-panel { width: 100%; padding: 50px 30px; }
        }
    </style>
</head>
<body>

<div class="deco">
    <div class="deco-logo">🎓</div>
    <h1>Intranet<br><span>SENATI</span></h1>
    <p>Sistema de gestión académica para estudiantes y administradores de la institución.</p>
    <div class="pills">
        <span class="pill">Biblioteca</span>
        <span class="pill">Alumnos</span>
        <span class="pill">Reportes</span>
        <span class="pill">Estadísticas</span>
    </div>
</div>

<div class="login-panel">
    <p class="tag">Inicio de sesión</p>
    <h2>Bienvenido(a)</h2>
    <p class="sub">Ingresa con tu ID de estudiante y contraseña</p>

    <?php if (!empty($error)): ?>
        <div class="error-box">⚠️ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php" autocomplete="off">
        <label for="id_estudiante">ID de Estudiante</label>
        <div class="input-wrap">
            <span class="ico">🪪</span>
            <input type="number" id="id_estudiante" name="id_estudiante"
                   placeholder="Ej: 1675700" required autofocus>
        </div>

        <label for="password">Contraseña</label>
        <div class="input-wrap">
            <span class="ico">🔒</span>
            <input type="password" id="password" name="password"
                   placeholder="Tu contraseña" required>
        </div>

        <button type="submit" class="btn-login">Ingresar al sistema →</button>
    </form>

    <div class="footer-login">© <?php echo date('Y'); ?> SENATI Huánuco · Sistema académico</div>
</div>

</body>
</html>
