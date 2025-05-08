function showAlert(type, message) {
    const container = document.getElementById('alertContainer');
    if (!container) return;

    const id = 'alert-' + Date.now();

    const icons = {
        success: '/assets/success.json',
        warning: '/assets/warning.json',
        failed: '/assets/failed.json'
    };

    const bgColor = {
        success: 'bg-[#EAFFF1] border-[#048730] text-[#048730]',
        warning: 'bg-[#FFFDF1] border-[#8A7300] text-[#8A7300]',
        failed:  'bg-[#FEF0F0] border-[#850000] text-[#850000]'
    };
    
    const alert = document.createElement('div');
    alert.className = `flex items-center gap-2 max-w-sm border-l-4 shadow-lg rounded-lg px-4 py-3 animate-slideIn ${bgColor[type] || bgColor.warning}`;
    alert.id = id;
    
    alert.innerHTML = `
        <div id="lottie-${id}" class="w-10 h-10"></div>
        <div class="flex-1">${message}</div>
        <button onclick="document.getElementById('${id}').remove()" class="text-xl font-bold px-2">&times;</button>
    `;

    container.appendChild(alert);

    lottie.loadAnimation({
        container: document.getElementById('lottie-' + id),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: icons[type] || icons.warning
    });

    setTimeout(() => {
        alert.remove();
    }, 4000);
}
