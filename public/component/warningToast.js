window.showWarningToast = function(message = 'Ada yang salah!', duration = 3000) {
    const id = Date.now();
    const container = document.getElementById('toastContainer');

    const toast = document.createElement('div');
    toast.className = 'flex items-center p-4 max-w-xs text-sm text-white bg-red-600 rounded-lg shadow-lg z-[9999]';
    toast.innerHTML = `
        <div class="w-6 h-6 mr-2" id="lottie-${id}"></div>
        <span class="flex-1">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">&times;</button>
    `;

    container.appendChild(toast);

    // Load Lottie
    lottie.loadAnimation({
        container: document.getElementById(`lottie-${id}`),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: '/assets/warning.json'
    });

    // Auto close
    setTimeout(() => {
        toast.remove();
    }, duration);
}
