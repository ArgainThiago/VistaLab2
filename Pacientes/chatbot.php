<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaludChat</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f0f0f0; }
        #chatbox {
            background: #fff; padding: 15px; border-radius: 10px;
            width: 400px; height: 300px; overflow-y: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .msg { margin: 5px 0; }
        .user { color: blue; }
        .bot { color: green; }
        input { width: 320px; padding: 5px; }
        button { padding: 6px 10px; margin-left: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>SaludChat</h2>
    <div id="chatbox"></div>
    <input type="text" id="mensaje" placeholder="Escribe tu mensaje..."/>
    <button onclick="enviarMensaje()">Enviar</button>
    <button onclick="location.href='SegundaPagina.php'" class="Volver">Volver</button>
    <script>
        async function enviarMensaje() {
            const mensaje = document.getElementById('mensaje').value;
            const chatbox = document.getElementById('chatbox');
            chatbox.innerHTML += `<div class="msg user"><b>Tú:</b> ${mensaje}</div>`;
            document.getElementById('mensaje').value = "";

            try {
                const respuesta = await fetch("https://joana-fishless-hung.ngrok-free.dev/chatbot", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ mensaje })
                });

                if (!respuesta.ok) throw new Error(`Error del servidor: ${respuesta.status}`);

                const data = await respuesta.json();
                chatbox.innerHTML += `<div class="msg bot"><b>Bot:</b> ${data.respuesta}</div>`;
            } catch (error) {
                chatbox.innerHTML += `<div class="msg bot" style="color:red;"><b>Error:</b> ${error.message}</div>`;
            }
        }
    </script>
</body>
</html>
