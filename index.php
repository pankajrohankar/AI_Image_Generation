<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Event Image Generator</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f0f0;
      padding: 40px;
      display: flex;
      justify-content: center;
    }

    .container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 100%;
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 500;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-top: 5px;
      font-size: 15px;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      background: #0066ff;
      color: white;
      padding: 12px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      margin-top: 20px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:disabled {
      background: #ccc;
      cursor: not-allowed;
    }

    button:hover:enabled {
      background: #004ccf;
    }

    #imagePreview img {
      display: block;
      margin: 20px auto 0;
      border: 1px solid #ccc;
      border-radius: 10px;
      max-width: 100%;
      height: auto;
    }

    #loading {
      display: none;
      text-align: center;
      margin-top: 20px;
    }

    .spinner {
      border: 6px solid #f3f3f3;
      border-top: 6px solid #3498db;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 1s linear infinite;
      margin: 10px auto;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @media (max-width: 600px) {
      .container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Event Image Generator</h2>
  <form id="eventForm">
    <label for="event_name">Event Name</label>
    <input type="text" id="event_name" name="event_name" required>

    <label for="event_description">Event Description</label>
    <textarea id="event_description" name="event_description" rows="4" required></textarea>

    <button type="button" id="generateBtn" onclick="generateImage()" disabled>Generate Event Image</button>
  </form>

  <div id="loading">
    <img src="spinner.gif" alt="Loading..." width="50">
    <p>Generating image, please wait...</p>
  </div>

  <div id="imagePreview"></div>
</div>

<script>
const eventNameInput = document.getElementById('event_name');
const descriptionInput = document.getElementById('event_description');
const generateBtn = document.getElementById('generateBtn');

// Enable button only when both fields have values
function validateForm() {
  const name = eventNameInput.value.trim();
  const desc = descriptionInput.value.trim();
  generateBtn.disabled = !(name && desc);
}

// Attach real-time listeners
eventNameInput.addEventListener('input', validateForm);
descriptionInput.addEventListener('input', validateForm);

function generateImage() {
  const eventName = eventNameInput.value.trim();
  const description = descriptionInput.value.trim();

  document.getElementById('loading').style.display = 'block';
  document.getElementById('imagePreview').innerHTML = '';

  fetch('generate_image.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      event_name: eventName,
      event_description: description
    })
  })
  .then(response => response.json())
  .then(data => {
    document.getElementById('loading').style.display = 'none';
    if (data.image_url) {
      document.getElementById('imagePreview').innerHTML = `<img src="${data.image_url}" alt="Generated Event Image">`;
    } else {
      document.getElementById('imagePreview').innerHTML = `<p style="color: red;">Image generation failed.</p>`;
    }
  })
  .catch(error => {
    document.getElementById('loading').style.display = 'none';
    document.getElementById('imagePreview').innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
  });
}
</script>

</body>
</html>
