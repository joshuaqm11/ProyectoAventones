<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Activa tu cuenta</title>
</head>
<body>
    <h2>Hola, {{ $usuario->nombre }} {{ $usuario->apellido }}</h2>

    <p>
        Gracias por registrarte en <strong>ProyectoAventones</strong>.
    </p>

    <p>
        Tu cuenta está actualmente en estado <strong>Pendiente</strong>.  
        Para activarla y poder iniciar sesión, haz clic en el siguiente botón:
    </p>

    <p>
        <a href="{{ $urlActivacion }}"
           style="background:#2563eb;color:#fff;padding:10px 16px;
                  text-decoration:none;border-radius:6px;display:inline-block;">
            Activar mi cuenta
        </a>
    </p>

    <p>Si el botón no funciona, copia y pega este enlace en tu navegador:</p>

    <p>{{ $urlActivacion }}</p>

    <p>Si no realizaste este registro, puedes ignorar este mensaje.</p>

    <p>Saludos,<br>Equipo ProyectoAventones</p>
</body>
</html>
