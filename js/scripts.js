document.addEventListener('DOMContentLoaded', function () {
    // Seleciona o link "Sair" no menu
    const logoutLink = document.querySelector('a[href="logout.php"]');
    const exitMessage = document.getElementById('exit-message');
    const closeMessageButton = document.getElementById('close-exit-message');
    const confirmLogoutLink = document.getElementById('confirm-logout');

    if (logoutLink) {
        // Mostra a mensagem ao clicar em "Sair"
        logoutLink.addEventListener('click', function (event) {
            event.preventDefault();
            exitMessage.classList.remove('hidden');
        });
    }

    // Fecha a mensagem ao clicar em "Fechar"
    if (closeMessageButton) {
        closeMessageButton.addEventListener('click', function () {
            exitMessage.classList.add('hidden');
        });
    }

    // Continua para o logout ao clicar em "Confirmar Logout"
    if (confirmLogoutLink) {
        confirmLogoutLink.addEventListener('click', function () {
            exitMessage.classList.add('hidden');
        });
    }
});



