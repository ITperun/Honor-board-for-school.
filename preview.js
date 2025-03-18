document.getElementById('addPostForm').addEventListener('input', function () {
    const name = document.querySelector('input[name="name"]').value;
    const classGroup = document.querySelector('input[name="class"]').value;
    const recordDescription = document.querySelector('input[name="record_description"]').value;
    const date = document.querySelector('input[name="date"]').value;
    const image = document.querySelector('input[name="image"]').files[0];

    const previewDiv = document.getElementById('preview');
    
    if (name && classGroup && recordDescription && date && image) {
        const reader = new FileReader();
        reader.onload = function (e) {
            previewDiv.innerHTML = `
                <h3>Náhled:</h3>
                <div class="preview-container">
                    <img src="${e.target.result}" alt="Obrázek" class="preview-image">
                    <div class="preview-text">
                        <p><strong>${recordDescription}</strong></p>
                        <p><strong>Datum:</strong> ${date}</p>
                        <p><strong>Jméno:</strong> ${name}</p>
                        <p><strong>Třída:</strong> ${classGroup}</p>
                    </div>
                </div>
            `;
        };
        reader.readAsDataURL(image);
    } else {
        previewDiv.innerHTML = '';
    }
});
