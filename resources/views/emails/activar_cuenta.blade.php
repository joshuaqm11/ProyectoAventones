<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Activar cuenta - ProyectoAventones</title>
</head>
<body>
    <h1>Bienvenido(a) a ProyectoAventones</h1>

    <p>Hola {{ $usuario->nombre }},</p>

    <p>Gracias por registrarte en ProyectoAventones. Para activar tu cuenta, haz clic en el siguiente enlace:</p>

    <p>
        <a href="{{ route('activar', $usuario->token_activacion) }}">
            Activar mi cuenta
        </a>
    </p>

    <p>Si tú no creaste esta cuenta, puedes ignorar este correo.</p>
</body>
</html>
