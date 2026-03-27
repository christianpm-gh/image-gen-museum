<!DOCTYPE html>
<html lang="es">
    <body style="margin:0;background:#020617;color:#e2e8f0;font-family:'Segoe UI',sans-serif;">
        <div style="max-width:680px;margin:0 auto;padding:32px 20px;">
            <div style="background:#0f172a;border:1px solid rgba(56,189,248,0.25);border-radius:24px;padding:32px;">
                <p style="letter-spacing:0.3em;text-transform:uppercase;color:#7dd3fc;font-size:12px;margin:0 0 12px;">MusIAum</p>
                <h1 style="margin:0 0 16px;font-size:32px;line-height:1.1;color:white;">Tu acceso ya está listo</h1>
                <p style="margin:0 0 24px;font-size:16px;line-height:1.7;color:#cbd5e1;">
                    Tu recorrido quedó abierto. Conserva este ticket y usa el enlace cuando quieras entrar al espacio donde transformarás una emoción en un recuerdo.
                </p>

                <div style="background:#020617;border:1px solid rgba(148,163,184,0.25);border-radius:20px;padding:20px;margin-bottom:24px;">
                    <p style="margin:0 0 10px;color:#94a3b8;font-size:13px;text-transform:uppercase;letter-spacing:0.18em;">Tipo de entrada</p>
                    <p style="margin:0 0 16px;color:white;font-size:24px;font-weight:700;">{{ $ticket->ticket_type->label() }}</p>

                    <p style="margin:0 0 10px;color:#94a3b8;font-size:13px;text-transform:uppercase;letter-spacing:0.18em;">UUID del ticket</p>
                    <p style="margin:0 0 16px;color:#e2e8f0;font-size:15px;">{{ $ticket->uuid }}</p>

                    <p style="margin:0 0 10px;color:#94a3b8;font-size:13px;text-transform:uppercase;letter-spacing:0.18em;">Token de acceso</p>
                    <p style="margin:0;color:#e2e8f0;font-size:15px;">{{ $plainToken }}</p>
                </div>

                <a href="{{ $accessUrl }}" style="display:inline-block;background:#38bdf8;color:#020617;text-decoration:none;padding:14px 22px;border-radius:16px;font-weight:700;">
                    Abrir espacio de creación
                </a>

                <p style="margin:24px 0 0;font-size:14px;line-height:1.7;color:#94a3b8;">
                    Si lo prefieres, conserva también el UUID y el token como respaldo de tu acceso.
                </p>
            </div>
        </div>
    </body>
</html>
