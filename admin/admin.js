function editFile(path) {
    fetch(`?preview&path=${encodeURIComponent(path)}`)
        .then(response => response.text())
        .then(content => {
            document.getElementById('filePath').value = path;
            document.getElementById('fileContent').value = content;
            document.getElementById('editor').style.display = 'block';
        });
}

function hideEditor() {
    document.getElementById('editor').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[method="post"]').forEach(form => {
        form.addEventListener('submit', e => {
            if (form.querySelector('[name="delete"]')) {
                if (!confirm('Delete this item?')) {
                    e.preventDefault();
                }
            }
        });
    });
});