<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT en JavaScript</title>
</head>
<body>
    <div>
        <h1>ChatGPT</h1>
        <div id="chat-container"></div>
        <input type="text" id="user-input" placeholder="Escribe un mensaje...">
        <button onclick="enviarMensaje()">Enviar</button>
    </div>

    <script>
        const apiKey = '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'; // Reemplaza con tu clave API
        const chatContainer = document.getElementById('chat-container');
        const userInput = document.getElementById('user-input');

        async function enviarMensaje() {
            const mensajeUsuario = userInput.value;
            
            // Realizar solicitud a la API de OpenAI
            const respuesta = await obtenerRespuesta(mensajeUsuario);

            // Mostrar la respuesta en la interfaz de usuario
            mostrarMensaje(mensajeUsuario, 'usuario');
            mostrarMensaje(respuesta, 'chatbot');

            // Limpiar el campo de entrada
            userInput.value = '';
        }

        async function obtenerRespuesta(prompt) {
            const url = 'https://api.openai.com/v1/engines/davinci-codex/completions';
            
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${apiKey}`
                },
                body: JSON.stringify({
                    prompt: prompt,
                    max_tokens: 150
                })
            });

            const data = await response.json();
            return data.choices[0].text.trim();
        }

        function mostrarMensaje(mensaje, remitente) {
            const mensajeElement = document.createElement('div');
            mensajeElement.className = remitente;
            mensajeElement.innerText = mensaje;
            chatContainer.appendChild(mensajeElement);
        }
    </script>
    <script src="https://api.openai.com/v1/engines/davinci/completions?prompt={HOLA}&temperature={0.1}&max_tokens={30}&echo={true}&api_key={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}"></script>

</body>
</html>
