const messagesDiv = document.getElementById('messages');
const input = document.getElementById('input');
const sendBtn = document.getElementById('send');

function addMessage(role, text) {
  const div = document.createElement('div');
  div.classList.add('msg');
  div.classList.add(role);
  div.textContent = `${role === 'user' ? 'Você' : 'Ollama'}: ${text}`;
  messagesDiv.appendChild(div);
  messagesDiv.scrollTop = messagesDiv.scrollHeight;
}

async function sendMessage() {
  const text = input.value.trim();
  if (!text) return;
  addMessage('user', text);
  input.value = '';

  try {
    const response = await fetch('ollama_proxy.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        model: "gemma3:1b",  // or any other local model name
        prompt: text,
        stream: false        // 🚀 this line fixes the JSON parsing error
      })
    });

    const data = await response.json();

    const reply = data.response || "Erro: resposta vazia.";
    addMessage('bot', reply);

  } catch (err) {
    addMessage('bot', "Erro: " + err.message);
  }
}

sendBtn.addEventListener('click', sendMessage);
input.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') sendMessage();
});
