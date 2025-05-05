document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const imagesJsonInput = document.getElementById('imagesJsonInput');
    
    let imageList = [];
    
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
    
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert("File harus berupa gambar (jpg, jpeg, png, webp)");
                return;
            }
    
            if (file.size > 2 * 1024 * 1024) {
                alert("Ukuran maksimal 2MB");
                return;
            }
    
            const reader = new FileReader();
            reader.onload = function(e) {
                const base64 = e.target.result;
    
                imageList.push(base64);
                imagesJsonInput.value = JSON.stringify(imageList);
    
                const card = document.createElement('div');
                card.className = "relative rounded-lg overflow-hidden shadow-md group";
    
                card.innerHTML = `
                    <img src="${base64}" class="w-full h-40 object-cover">
                    <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition"
                            onclick="removeImage(this)">
                        &times;
                    </button>
                `;
    
                previewContainer.prepend(card);
            };
            reader.readAsDataURL(file);
    
            this.value = '';
        });
    } else {
        console.warn("Image input element not found");
    }
    
    window.removeImage = function(button) {
        const card = button.parentElement;
        const imgSrc = card.querySelector('img').src;
    
        imageList = imageList.filter(src => src !== imgSrc);
        if (imagesJsonInput) {
            imagesJsonInput.value = JSON.stringify(imageList);
        }
    
        card.remove();
    };
    
    let isScannerActive = false;
    let scannerTimeout = null;
    let videoStream = null;
    
    window.initScanner = function(modalId) {
        if (isScannerActive || typeof Quagga === 'undefined') return;
        
        const modalElement = document.getElementById(modalId);
        if (!modalElement) {
            console.error("Modal element not found:", modalId);
            return;
        }
        
        const interactiveElement = modalElement.querySelector('#interactive');
        if (!interactiveElement) {
            console.error("Scanner container not found in modal:", modalId);
            return;
        }
    
        const config = {
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: interactiveElement,
                constraints: {
                    width: { min: 640 },
                    height: { min: 480 },
                    facingMode: "environment"
                },
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            numOfWorkers: navigator.hardwareConcurrency || 4,
            frequency: 10,
            decoder: {
                readers: [
                    "ean_reader",
                    "ean_8_reader",
                    "code_128_reader",
                    "code_39_reader",
                    "code_39_vin_reader",
                    "codabar_reader",
                    "upc_reader",
                    "upc_e_reader"
                ]
            },
            locate: true
        };
    
        Quagga.init(config, function(err) {
            if (err) {
                console.error("Error initializing scanner:", err);
                alert("Gagal memulai scanner: " + err.message);
                return;
            }
    
            const videoElement = document.querySelector('#interactive video');
            if (videoElement) {
                videoStream = videoElement.srcObject;
            }
    
            Quagga.start();
            isScannerActive = true;
    
            scannerTimeout = setTimeout(() => {
                if (isScannerActive) {
                    alert("Scanner tidak mendeteksi barcode, silakan coba lagi");
                    closeScannerModal();
                }
            }, 30000);
        });
    
        Quagga.onDetected(function(result) {
            const code = result.codeResult.code;
            console.log("Barcode detected:", code);

            let barcodeInput;
            if (modalElement && modalElement.closest('form')) {
                const form = modalElement.closest('form');
                barcodeInput = form.querySelector('#barcode');
            }
            
            if (!barcodeInput) {
                barcodeInput = document.getElementById('barcode');
            }
            
            if (barcodeInput) {
                barcodeInput.value = code;
            }
            
            playBeepSound();
            closeScannerModal(modalId);
        });
    };
    
    window.closeScannerModal = function(modalId) {
        let scannerModal;
        if (modalId) {
            scannerModal = document.getElementById(modalId);
        } else {
            scannerModal = document.querySelector('[id^="scanner-"]:not(.hidden)');
        }
        
        if (scannerModal) {
            scannerModal.classList.add('hidden');
        }
    
        if (isScannerActive) {
            Quagga.stop();
            isScannerActive = false;
    
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                videoStream = null;
            }
    
            const videoElement = document.querySelector('#interactive video');
            if (videoElement) {
                videoElement.remove();
            }
        }
    
        if (scannerTimeout) {
            clearTimeout(scannerTimeout);
            scannerTimeout = null;
        }
    };
    
    window.openModal = function(modalId) {
        const modalElement = document.getElementById(modalId);
        if (!modalElement) {
            console.error("Modal element not found:", modalId);
            return;
        }
        
        modalElement.classList.remove('hidden');
        
        if (modalId.includes('scanner-')) {
            const interactiveDiv = modalElement.querySelector('#interactive');
            if (interactiveDiv && !interactiveDiv.querySelector('video')) {
                interactiveDiv.innerHTML = '<video autoplay playsinline></video>';
            }
            window.initScanner(modalId);
        }
    };
    
    window.closeModal = function(modalId) {
        const modalElement = document.getElementById(modalId);
        if (modalElement) {
            modalElement.classList.add('hidden');
        }
        
        if (modalId.includes('scanner-')) {
            window.closeScannerModal(modalId);
        }
    };
    
    window.playBeepSound = function() {
        try {
            const audioCtx = new(window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();
    
            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);
    
            oscillator.type = "sine";
            oscillator.frequency.value = 800;
            gainNode.gain.value = 0.1;
    
            oscillator.start();
            gainNode.gain.exponentialRampToValueAtTime(0.00001, audioCtx.currentTime + 0.1);
            oscillator.stop(audioCtx.currentTime + 0.1);
        } catch (e) {
            console.log("Audio error:", e);
        }
    };
});