async function handleRegistration(event) {
    event.preventDefault();

    const password = String(document.getElementById('password').value);
    const confirmPassword = String(document.getElementById('confirmPassword').value);

    if (password !== confirmPassword) {
        showError('Пароли не совпадают');
        return;
    }

    const idUser = await generateUserId();
    const salt = await generateSalt();
    const passwordHash = await hashPassword(password);

    const formData = {
        id: idUser,
        username: document.getElementById('username').value.trim(),
        email: document.getElementById('email').value.trim(),
        salt: salt,
        passwordHash: password,
    };

    try {
        const response = await fetch('/registration', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = '/';
        } else {
            showError(data.message || 'Ошибка регистрации');
        }
    } catch (error) {
        showError('Ошибка сети');
    }
}

async function generateSalt(length = 16) {
    const salt = new Uint8Array(length);
    crypto.getRandomValues(salt);
    return Array.from(salt).map(b => b.toString(16).padStart(2, '0')).join('');
}

async function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

async function generateUserId() {
    const buffer = new Uint8Array(16);
    crypto.getRandomValues(buffer);

    buffer[6] = (buffer[6] & 0x0f) | 0x40;
    buffer[8] = (buffer[8] & 0x3f) | 0x80;

    return Array.from(buffer)
        .map(b => b.toString(16).padStart(2, '0'))
        .join('')
        .match(/(.{8})(.{4})(.{4})(.{4})(.{12})/)
        .slice(1)
        .join('-');
}

// Функция отображения ошибок (остается без изменений)
function showError(message) {
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.style.color = '#e53e3e';
    errorElement.style.marginBottom = '1rem';
    errorElement.style.textAlign = 'center';
    errorElement.textContent = message;

    const container = document.querySelector('.auth-container');
    container.insertBefore(errorElement, container.firstChild);

    setTimeout(() => errorElement.remove(), 5000);
}