async function handleSubmit(event) {
    event.preventDefault();

    const password = String(document.getElementById('password').value);
    const formData = {
        email: document.getElementById('email').value.trim(),
        password: password,
        remember: document.getElementById('rememberMe').checked
    };

    try {
        const response = await fetch('/authorization', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();
        console.log('Ответ сервера:', data);

        if (data.success) {
            window.location.href = data.redirect || '/';
        } else {
            alert(data.error || 'Authorization failed');
        }
    } catch (error) {
        showError(error.message);
    }
}

const logOutBtn = document.getElementById("logout-btn");
logOutBtn.addEventListener("click", async (event) => {
    event.preventDefault();

    try {
        const response = await fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        const data = await response.json();

        if (data.redirect) {
            window.location.href = '/';
        }
    } catch (error) {
        console.error('Ошибка выхода:', error);
    }
});

async function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

function showError(message) {
    const errorElement = document.createElement('div');
    errorElement.className = 'error-message';
    errorElement.textContent = message;
    document.querySelector('.auth-container').prepend(errorElement);

    setTimeout(() => errorElement.remove(), 5000);
}