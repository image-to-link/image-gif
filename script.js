document.getElementById('uploadForm').addEventListener('submit', async function (e) {
  e.preventDefault();
  const fileInput = document.getElementById('imageInput');
  const result = document.getElementById('result');

  const formData = new FormData();
  formData.append('image', fileInput.files[0]);

  const response = await fetch('upload.php', {
    method: 'POST',
    body: formData
  });

  const data = await response.json();

  if (data.success) {
    result.innerHTML = `
      ✅ Image uploaded!<br>
      <strong>Link:</strong> <a href="${data.url}" target="_blank">${data.url}</a><br>
      <img src="${data.url}" alt="Uploaded Image">
    `;
  } else {
    result.innerHTML = `❌ Error: ${data.error}`;
  }
});
