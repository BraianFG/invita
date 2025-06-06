    document.getElementById('imagen').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    preview.innerHTML = '';
    if (file) {
        if (!file.type.startsWith('image/')) {
            alert('Por favor, selecciona un archivo de imagen válido.');
            this.value = ''; // Limpia el input
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '70px';
            img.style.width = '70px'; // Fija el ancho
            img.style.height = '70px'; // Fija el alto para hacerlo cuadrado
            img.style.borderRadius = '4px'; // Ajusta el borde redondeado
            img.style.objectFit = 'cover'; // Asegura que la imagen llene el espacio
            img.style.display = 'block'; // Asegura que la imagen sea un bloque
            img.style.margin = '0 auto'; // Centra la imagen horizontalmente
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});