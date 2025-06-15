document.addEventListener("DOMContentLoaded", function () {
    const discountToggle = document.getElementById("discount-toggle");
    const discountContainer = document.getElementById("discount-container");
    const discountArrow = document.getElementById("discount-arrow");
    const applyDiscountBtn = document.getElementById(
        "apply-transaction-discount"
    );
    const payNowBtn = document.getElementById("pay-now");
    // const holdTransactionBtn = document.getElementById('hold-transaction');
    const cancelTransactionBtn = document.getElementById("cancel-transaction");

    let selectedProducts = [];
    let transactionDiscount = {
        amount: 0,
        type: "fixed",
    };

    initScanner();

    discountToggle.addEventListener("click", toggleDiscountDisplay);
    applyDiscountBtn.addEventListener("click", applyTransactionDiscount);
    payNowBtn.addEventListener("click", processPayment);
    // holdTransactionBtn.addEventListener('click', holdTransaction);
    cancelTransactionBtn.addEventListener("click", cancelTransaction);

    document.querySelectorAll(".product-card").forEach((card) => {
        card.addEventListener("click", function () {
            const productId = this.dataset.id;
            selectProduct(productId, "click");
        });
    });

    function toggleDiscountDisplay() {
        discountContainer.classList.toggle("hidden");
        const isHidden = discountContainer.classList.contains("hidden");
        document.getElementById("discount-label").textContent = isHidden
            ? "Tambah Diskon"
            : "Tutup Diskon";
        discountArrow.classList.toggle("rotate-180");
    }

    function applyTransactionDiscount() {
        const amount =
            parseFloat(document.getElementById("discount-amount").value) || 0;
        const type = document.getElementById("discount-type").value;

        transactionDiscount = {
            amount,
            type,
        };
        updateTotals();

        discountContainer.classList.add("hidden");
        document.getElementById("discount-label").textContent = "Tambah Diskon";
        discountArrow.classList.remove("rotate-180");
    }

    function selectProduct(productId, source = "click") {
        const productCard = document.querySelector(
            `.product-card[data-id="${productId}"]`
        );
        if (!productCard) {
            console.log("Product not found in DOM");
            return false;
        }

        const product = {
            id: productId,
            name: productCard.dataset.name,
            price: parseFloat(productCard.dataset.price),
            cost: parseFloat(productCard.dataset.cost),
            category: productCard.dataset.category,
            stock: parseInt(productCard.dataset.stock),
            barcode: productCard.dataset.barcode || null,
        };

        const existingProduct = selectedProducts.find(
            (p) => p.id === productId
        );

        if (existingProduct) {
            existingProduct.quantity += 1;
            existingProduct.subtotal = calculateSubtotal(existingProduct);
            updateProductRow(productId);
        } else {
            addProductToTable(product);
        }

        const indicator = productCard.querySelector(".cart-indicator");
        indicator.classList.remove("hidden");

        if (source === "click") {
            productCard.classList.add("click-selected");
            setTimeout(() => {
                productCard.classList.remove("click-selected");
            }, 500);
        } else {
            productCard.classList.add("scan-selected");
            setTimeout(() => {
                productCard.classList.remove("scan-selected");
            }, 1000);
        }

        return true;
    }

    function addProductToTable(product) {
        const container = document.getElementById("selected-products");
        const placeholder = container.querySelector(".no-products");
        if (placeholder) placeholder.remove();

        const template = document.getElementById("product-row-template");
        const clone = template.content.cloneNode(true);
        const row = clone.querySelector(".product-row");
        row.setAttribute("data-id", product.id);

        row.querySelector(".product-name").textContent = product.name;
        row.querySelector(".product-code").textContent = product.barcode
            ? `# ${product.barcode}`
            : `# ${product.id}`;
        row.querySelector(".product-subtotal").textContent = formatCurrency(
            product.price
        );

        container.appendChild(clone);

        selectedProducts.push({
            id: product.id,
            name: product.name,
            price: product.price,
            cost: product.cost,
            quantity: 1,
            discount: {
                amount: 0,
                type: "fixed",
            },
            subtotal: product.price,
            barcode: product.barcode,
        });

        setupProductRowEvents(row, product.id);
        updateTotals();
    }

    function setupProductRowEvents(row, productId) {
        const quantityInput = row.querySelector(".quantity-input");
        const decreaseBtn = row.querySelector(".decrease-qty");
        const increaseBtn = row.querySelector(".increase-qty");
        const removeBtn = row.querySelector(".remove-product");
        const toggleDiscountBtn = row.querySelector(".toggle-discount");
        const applyDiscountBtn = row.querySelector(".apply-discount");
        const discountContainer = row.querySelector(
            ".product-discount-container"
        );
        const discountAmountInput = row.querySelector(".item-discount-amount");
        const discountTypeSelect = row.querySelector(".item-discount-type");
        const discountDisplay = row.querySelector(".product-discount-display");

        const handleQuantityChange = () => {
            const newQuantity = parseInt(quantityInput.value) || 1;
            updateProductQuantity(productId, newQuantity);
        };

        quantityInput.addEventListener("change", handleQuantityChange);
        quantityInput.addEventListener("blur", handleQuantityChange);

        decreaseBtn.addEventListener("click", (event) => {
            event.preventDefault();
            const currentQty = parseInt(quantityInput.value);
            if (currentQty > 1) {
                quantityInput.value = currentQty - 1;
                quantityInput.dispatchEvent(new Event("change"));
            }
        });

        increaseBtn.addEventListener("click", (event) => {
            event.preventDefault();
            const currentQty = parseInt(quantityInput.value) || 0;
            quantityInput.value = currentQty + 1;
            quantityInput.dispatchEvent(new Event("change"));
        });

        removeBtn.addEventListener("click", () => removeProduct(productId));

        toggleDiscountBtn.addEventListener("click", function () {
            discountContainer.classList.toggle("hidden");
            this.querySelector("svg").classList.toggle("rotate-180");
        });

        applyDiscountBtn.addEventListener("click", function () {
            const discountAmount = parseFloat(discountAmountInput.value) || 0;
            const discountType = discountTypeSelect.value;
            updateProductDiscount(productId, discountAmount, discountType);

            discountContainer.classList.add("hidden");
            toggleDiscountBtn
                .querySelector("svg")
                .classList.remove("rotate-180");

            if (discountAmount > 0) {
                discountDisplay.classList.remove("hidden");
                discountDisplay.querySelector(".discount-amount").textContent =
                    discountType === "fixed"
                        ? "Rp " + discountAmount.toLocaleString("id-ID")
                        : discountAmount + "%";
            } else {
                discountDisplay.classList.add("hidden");
            }
        });
    }

    function updateProductRow(productId) {
        const product = selectedProducts.find((p) => p.id === productId);
        const row = document.querySelector(
            `.product-row[data-id="${productId}"]`
        );
        if (product && row) {
            row.querySelector(".product-subtotal").textContent = formatCurrency(
                product.subtotal
            );
            row.querySelector(".quantity-input").value = product.quantity;
        }
        updateTotals();
    }

    function updateProductQuantity(productId, newQuantity) {
        const product = selectedProducts.find((p) => p.id === productId);
        if (product) {
            product.quantity = newQuantity;
            product.subtotal = calculateSubtotal(product);
            updateProductRow(productId);
        }
    }

    function updateProductDiscount(productId, amount, type) {
        const product = selectedProducts.find((p) => p.id === productId);
        if (product) {
            product.discount = {
                amount,
                type,
            };
            product.subtotal = calculateSubtotal(product);
            updateProductRow(productId);
        }
    }

    function calculateSubtotal(product) {
        let subtotal = product.price * product.quantity;
        if (product.discount.amount > 0) {
            subtotal -=
                product.discount.type === "fixed"
                    ? product.discount.amount
                    : subtotal * (product.discount.amount / 100);
        }
        return Math.max(0, subtotal);
    }

    function removeProduct(productId) {
        selectedProducts = selectedProducts.filter((p) => p.id !== productId);
        const row = document.querySelector(
            `.product-row[data-id="${productId}"]`
        );
        if (row) row.remove();

        const productCard = document.querySelector(
            `.product-card[data-id="${productId}"]`
        );
        if (productCard) {
            productCard.classList.remove(
                "selected",
                "click-selected",
                "scan-selected"
            );
            const cartIndicator = productCard.querySelector(".cart-indicator");
            if (cartIndicator) cartIndicator.classList.add("hidden");
        }

        const container = document.getElementById("selected-products");
        if (container.children.length === 0) {
            container.innerHTML = `<div class="p-4 text-center text-gray-500 no-products">Belum ada produk dipilih</div>`;
        }
        updateTotals();
    }

    function updateTotals() {
        const subtotal = selectedProducts.reduce(
            (sum, product) => sum + product.price * product.quantity,
            0
        );
        const totalProductDiscounts = selectedProducts.reduce(
            (sum, product) => {
                if (product.discount.amount > 0) {
                    return (
                        sum +
                        (product.discount.type === "fixed"
                            ? product.discount.amount
                            : product.price *
                              product.quantity *
                              (product.discount.amount / 100))
                    );
                }
                return sum;
            },
            0
        );

        let transactionDiscAmount = 0;
        if (transactionDiscount.amount > 0) {
            transactionDiscAmount =
                transactionDiscount.type === "fixed"
                    ? transactionDiscount.amount
                    : (subtotal - totalProductDiscounts) *
                      (transactionDiscount.amount / 100);
        }

        const total = Math.max(
            0,
            subtotal - totalProductDiscounts - transactionDiscAmount
        );

        document.getElementById("subtotal").textContent =
            formatCurrency(subtotal);
        document.getElementById("subtotal-discount").textContent =
            formatCurrency(transactionDiscAmount);
        document.getElementById("total-discount").textContent = formatCurrency(
            totalProductDiscounts + transactionDiscAmount
        );
        document.getElementById("total-amount").textContent =
            formatCurrency(total);
    }

    function formatCurrency(amount) {
        return "Rp" + amount.toFixed(0).replace(/\d(?=(\d{3})+$)/g, "$&.");
    }

    function processPayment(e) {
        e.preventDefault();

        if (selectedProducts.length === 0) {
            alert("Tidak ada produk yang dipilih");
            return;
        }

        // Hitung total transaksi
        const totalJual = selectedProducts.reduce(
            (sum, product) => sum + product.price * product.quantity,
            0
        );
        const totalModal = selectedProducts.reduce(
            (sum, product) => sum + product.cost * product.quantity,
            0
        );

        // Siapkan data transaksi
        const transactionData = {
            items: selectedProducts.map((product) => ({
                product_id: product.id,
                quantity: product.quantity,
                harga_jual: product.price,
                harga_modal: product.cost,
            })),
            total_jual_keseluruhan: totalJual,
            total_modal_keseluruhan: totalModal,
        };

        // Set data ke input hidden form
        document.getElementById("data-transaksi").value =
            JSON.stringify(transactionData);

        // Submit form
        document.getElementById("transaksi-form").submit();
    }

    // function holdTransaction() {
    //     if (selectedProducts.length === 0) {
    //         alert('Tidak ada produk yang dipilih');
    //         return;
    //     }
    //     alert('Fungsi hold transaksi akan diimplementasikan disini');
    // }

    function cancelTransaction() {
        if (selectedProducts.length === 0) {
            alert("Tidak ada produk yang dipilih");
            return;
        }
        if (confirm("Apakah Anda yakin ingin membatalkan transaksi ini?")) {
            selectedProducts = [];
            document
                .querySelectorAll(".product-row")
                .forEach((row) => row.remove());
            document.querySelectorAll(".product-card").forEach((card) => {
                card.classList.remove(
                    "selected",
                    "click-selected",
                    "scan-selected"
                );
                const cartIndicator = card.querySelector(".cart-indicator");
                if (cartIndicator) cartIndicator.classList.add("hidden");
            });

            const container = document.getElementById("selected-products");
            container.innerHTML = `<div class="p-4 text-center text-gray-500 no-products">Belum ada produk dipilih</div>`;

            transactionDiscount = {
                amount: 0,
                type: "fixed",
            };
            document.getElementById("discount-amount").value = "";
            document.getElementById("discount-type").value = "fixed";
            discountContainer.classList.add("hidden");
            document.getElementById("discount-label").textContent =
                "Tambah Diskon";
            discountArrow.classList.remove("rotate-180");
            updateTotals();
        }
    }

    let scanningPaused = false;

    function initScanner() {
        const config = {
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#interactive"),
                constraints: {
                    width: {
                        ideal: 640,
                    },
                    height: {
                        ideal: 480,
                    },
                    facingMode: "environment",
                },
            },
            locator: {
                patchSize: "large",
                halfSample: false,
            },
            numOfWorkers: navigator.hardwareConcurrency || 4,
            frequency: 50,
            decoder: {
                readers: [
                    "ean_reader",
                    "ean_8_reader",
                    "code_128_reader",
                    "code_39_reader",
                    "code_39_vin_reader",
                    "codabar_reader",
                    "upc_reader",
                    "upc_e_reader",
                ],
                multiple: false,
            },
            locate: true,
            debug: false,
        };

        Quagga.init(config, function (err) {
            if (err) {
                console.error(err);
                alert("Scanner gagal dimulai");
                return;
            }
            Quagga.start();
        });

        Quagga.onDetected(function (result) {
            const code = result.codeResult.code;
            console.log("Scanned code:", code);

            if (scanningPaused) return;

            handleBarcodeDetection({
                codeResult: {
                    code,
                },
            });
        });
    }

    async function handleBarcodeDetection(result) {
        let code = result.codeResult.code?.trim();
        if (!code) return;

        console.log("Scanned code:", code);

        let productCard = document.querySelector(
            `.product-card[data-barcode="${code}"], .product-card[data-id="${code}"]`
        );

        if (productCard) {
            const productId = productCard.dataset.id;
            selectProduct(productId, "scan");
            playBeepSound();

            scanningPaused = true;
            setTimeout(() => {
                scanningPaused = false;
            }, 2000);

            return;
        }

        try {
            const response = await fetch(
                `/api/products/find?barcode=${encodeURIComponent(code)}`
            );
            if (response.ok) {
                const product = await response.json();

                if (product) {
                    const added = selectProduct(product.id, "scan");
                    if (added) {
                        playBeepSound();
                    } else {
                        alert(
                            `Produk "${product.name}" ditambahkan meskipun tidak terlihat di daftar saat ini`
                        );
                        addProductToTable(product);
                        playBeepSound();
                    }

                    scanningPaused = true;
                    setTimeout(() => {
                        scanningPaused = false;
                    }, 2000);

                    return;
                }
            }
        } catch (e) {
            console.error("Error checking product:", e);
        }
    }

    function playBeepSound() {
        try {
            const audioCtx = new (window.AudioContext ||
                window.webkitAudioContext)();
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);

            oscillator.type = "sine";
            oscillator.frequency.value = 800;
            gainNode.gain.value = 0.1;

            oscillator.start();
            gainNode.gain.exponentialRampToValueAtTime(
                0.00001,
                audioCtx.currentTime + 0.1
            );
            oscillator.stop(audioCtx.currentTime + 0.1);
        } catch (e) {
            console.log("Audio error:", e);
        }
    }

    window.addEventListener("beforeunload", function () {
        if (Quagga) {
            Quagga.offDetected(handleBarcodeDetection);
            Quagga.stop();
        }
    });
});
