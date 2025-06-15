// document.addEventListener("DOMContentLoaded", function () {
//     const discountToggle = document.getElementById("discount-toggle");
//     const discountContainer = document.getElementById("discount-container");
//     const discountArrow = document.getElementById("discount-arrow");
//     const applyDiscountBtn = document.getElementById(
//         "apply-transaction-discount"
//     );
//     const payNowBtn = document.getElementById("pay-now");
//     const holdTransactionBtn = document.getElementById("hold-transaction");
//     const cancelTransactionBtn = document.getElementById("cancel-transaction");

//     let selectedProducts = [];
//     let transactionDiscount = {
//         amount: 0,
//         type: "fixed",
//     };

//     initScanner();

//     discountToggle.addEventListener("click", toggleDiscountDisplay);
//     applyDiscountBtn.addEventListener("click", applyTransactionDiscount);
//     payNowBtn.addEventListener("click", processPayment);
//     holdTransactionBtn.addEventListener("click", holdTransaction);
//     cancelTransactionBtn.addEventListener("click", cancelTransaction);

//     document.querySelectorAll(".product-card").forEach((card) => {
//         card.addEventListener("click", function () {
//             const productId = this.dataset.id;
//             selectProduct(productId, "click");
//         });
//     });

//     function toggleDiscountDisplay() {
//         discountContainer.classList.toggle("hidden");
//         const isHidden = discountContainer.classList.contains("hidden");
//         document.getElementById("discount-label").textContent = isHidden
//             ? "Tambah Diskon"
//             : "Tutup Diskon";
//         discountArrow.classList.toggle("rotate-180");
//     }

//     function applyTransactionDiscount() {
//         const amount =
//             parseFloat(document.getElementById("discount-amount").value) || 0;
//         const type = document.getElementById("discount-type").value;

//         transactionDiscount = {
//             amount,
//             type,
//         };
//         updateTotals();

//         discountContainer.classList.add("hidden");
//         document.getElementById("discount-label").textContent = "Tambah Diskon";
//         discountArrow.classList.remove("rotate-180");
//     }

//     function selectProduct(productId, source = "click") {
//         const productCard = document.querySelector(
//             `.product-card[data-id="${productId}"]`
//         );
//         if (!productCard) {
//             console.log("Product not found in DOM");
//             return false;
//         }

//         const product = {
//             id: productId,
//             name: productCard.dataset.name,
//             price: parseFloat(productCard.dataset.price),
//             cost: parseFloat(productCard.dataset.cost),
//             category: productCard.dataset.category,
//             stock: parseInt(productCard.dataset.stock),
//             barcode: productCard.dataset.barcode || null,
//         };

//         const existingProduct = selectedProducts.find(
//             (p) => p.id === productId
//         );

//         if (existingProduct) {
//             existingProduct.quantity += 1;
//             existingProduct.subtotal = calculateSubtotal(existingProduct);
//             updateProductRow(productId);
//         } else {
//             addProductToTable(product);
//         }

//         const indicator = productCard.querySelector(".cart-indicator");
//         indicator.classList.remove("hidden");

//         if (source === "click") {
//             productCard.classList.add("click-selected");
//             setTimeout(() => {
//                 productCard.classList.remove("click-selected");
//             }, 500);
//         } else {
//             productCard.classList.add("scan-selected");
//             setTimeout(() => {
//                 productCard.classList.remove("scan-selected");
//             }, 1000);
//         }

//         return true;
//     }

//     function addProductToTable(product) {
//         const container = document.getElementById("selected-products");
//         const placeholder = container.querySelector(".no-products");
//         if (placeholder) placeholder.remove();

//         const template = document.getElementById("product-row-template");
//         const clone = template.content.cloneNode(true);
//         const row = clone.querySelector(".product-row");
//         row.setAttribute("data-id", product.id);

//         row.querySelector(".product-name").textContent = product.name;
//         row.querySelector(".product-code").textContent = product.barcode
//             ? `# ${product.barcode}`
//             : `# ${product.id}`;
//         row.querySelector(".product-subtotal").textContent = formatCurrency(
//             product.price
//         );

//         container.appendChild(clone);

//         selectedProducts.push({
//             id: product.id,
//             name: product.name,
//             price: product.price,
//             cost: product.cost,
//             quantity: 1,
//             discount: {
//                 amount: 0,
//                 type: "fixed",
//             },
//             subtotal: product.price,
//             barcode: product.barcode,
//         });

//         setupProductRowEvents(row, product.id);
//         updateTotals();
//     }

//     function setupProductRowEvents(row, productId) {
//         const quantityInput = row.querySelector(".quantity-input");
//         const decreaseBtn = row.querySelector(".decrease-qty");
//         const increaseBtn = row.querySelector(".increase-qty");
//         const removeBtn = row.querySelector(".remove-product");
//         const toggleDiscountBtn = row.querySelector(".toggle-discount");
//         const applyDiscountBtn = row.querySelector(".apply-discount");
//         const discountContainer = row.querySelector(
//             ".product-discount-container"
//         );
//         const discountAmountInput = row.querySelector(".item-discount-amount");
//         const discountTypeSelect = row.querySelector(".item-discount-type");
//         const discountDisplay = row.querySelector(".product-discount-display");

//         const handleQuantityChange = () => {
//             const newQuantity = parseInt(quantityInput.value) || 1;
//             updateProductQuantity(productId, newQuantity);
//         };

//         quantityInput.addEventListener("change", handleQuantityChange);
//         quantityInput.addEventListener("blur", handleQuantityChange);

//         decreaseBtn.addEventListener("click", () => {
//             const currentQty = parseInt(quantityInput.value);
//             if (currentQty > 1) {
//                 quantityInput.value = currentQty - 1;
//                 quantityInput.dispatchEvent(new Event("change"));
//             }
//         });

//         increaseBtn.addEventListener("click", () => {
//             const currentQty = parseInt(quantityInput.value);
//             quantityInput.value = currentQty + 1;
//             quantityInput.dispatchEvent(new Event("change"));
//         });

//         removeBtn.addEventListener("click", () => removeProduct(productId));

//         toggleDiscountBtn.addEventListener("click", function () {
//             discountContainer.classList.toggle("hidden");
//             this.querySelector("svg").classList.toggle("rotate-180");
//         });

//         applyDiscountBtn.addEventListener("click", function () {
//             const discountAmount = parseFloat(discountAmountInput.value) || 0;
//             const discountType = discountTypeSelect.value;
//             updateProductDiscount(productId, discountAmount, discountType);

//             discountContainer.classList.add("hidden");
//             toggleDiscountBtn
//                 .querySelector("svg")
//                 .classList.remove("rotate-180");

//             if (discountAmount > 0) {
//                 discountDisplay.classList.remove("hidden");
//                 discountDisplay.querySelector(".discount-amount").textContent =
//                     discountType === "fixed"
//                         ? "Rp " + discountAmount.toLocaleString("id-ID")
//                         : discountAmount + "%";
//             } else {
//                 discountDisplay.classList.add("hidden");
//             }
//         });
//     }

//     function updateProductRow(productId) {
//         const product = selectedProducts.find((p) => p.id === productId);
//         const row = document.querySelector(
//             `.product-row[data-id="${productId}"]`
//         );
//         if (product && row) {
//             row.querySelector(".product-subtotal").textContent = formatCurrency(
//                 product.subtotal
//             );
//             row.querySelector(".quantity-input").value = product.quantity;
//         }
//         updateTotals();
//     }

//     function updateProductQuantity(productId, newQuantity) {
//         const product = selectedProducts.find((p) => p.id === productId);
//         if (product) {
//             product.quantity = newQuantity;
//             product.subtotal = calculateSubtotal(product);
//             updateProductRow(productId);
//         }
//     }

//     function updateProductDiscount(productId, amount, type) {
//         const product = selectedProducts.find((p) => p.id === productId);
//         if (product) {
//             product.discount = {
//                 amount,
//                 type,
//             };
//             product.subtotal = calculateSubtotal(product);
//             updateProductRow(productId);
//         }
//     }

//     function calculateSubtotal(product) {
//         let subtotal = product.price * product.quantity;
//         if (product.discount.amount > 0) {
//             subtotal -=
//                 product.discount.type === "fixed"
//                     ? product.discount.amount
//                     : subtotal * (product.discount.amount / 100);
//         }
//         return Math.max(0, subtotal);
//     }

//     function removeProduct(productId) {
//         selectedProducts = selectedProducts.filter((p) => p.id !== productId);
//         const row = document.querySelector(
//             `.product-row[data-id="${productId}"]`
//         );
//         if (row) row.remove();

//         const productCard = document.querySelector(
//             `.product-card[data-id="${productId}"]`
//         );
//         if (productCard) {
//             productCard.classList.remove(
//                 "selected",
//                 "click-selected",
//                 "scan-selected"
//             );
//             const cartIndicator = productCard.querySelector(".cart-indicator");
//             if (cartIndicator) cartIndicator.classList.add("hidden");
//         }

//         const container = document.getElementById("selected-products");
//         if (container.children.length === 0) {
//             container.innerHTML = `<div class="p-4 text-center text-gray-500 no-products">Belum ada produk dipilih</div>`;
//         }
//         updateTotals();
//     }

//     function updateTotals() {
//         const subtotal = selectedProducts.reduce(
//             (sum, product) => sum + product.price * product.quantity,
//             0
//         );
//         const totalProductDiscounts = selectedProducts.reduce(
//             (sum, product) => {
//                 if (product.discount.amount > 0) {
//                     return (
//                         sum +
//                         (product.discount.type === "fixed"
//                             ? product.discount.amount
//                             : product.price *
//                               product.quantity *
//                               (product.discount.amount / 100))
//                     );
//                 }
//                 return sum;
//             },
//             0
//         );

//         let transactionDiscAmount = 0;
//         if (transactionDiscount.amount > 0) {
//             transactionDiscAmount =
//                 transactionDiscount.type === "fixed"
//                     ? transactionDiscount.amount
//                     : (subtotal - totalProductDiscounts) *
//                       (transactionDiscount.amount / 100);
//         }

//         const total = Math.max(
//             0,
//             subtotal - totalProductDiscounts - transactionDiscAmount
//         );

//         document.getElementById("subtotal").textContent =
//             formatCurrency(subtotal);
//         document.getElementById("subtotal-discount").textContent =
//             formatCurrency(transactionDiscAmount);
//         document.getElementById("total-discount").textContent = formatCurrency(
//             totalProductDiscounts + transactionDiscAmount
//         );
//         document.getElementById("total-amount").textContent =
//             formatCurrency(total);
//     }

//     function formatCurrency(amount) {
//         return "Rp" + amount.toFixed(0).replace(/\d(?=(\d{3})+$)/g, "$&.");
//     }

//     function processPayment() {
//         if (selectedProducts.length === 0) {
//             alert("Tidak ada produk yang dipilih");
//             return;
//         }

//         const subtotal = selectedProducts.reduce(
//             (sum, product) => sum + product.price * product.quantity,
//             0
//         );

//         const totalProductDiscounts = selectedProducts.reduce(
//             (sum, product) => {
//                 if (product.discount && product.discount.amount > 0) {
//                     return (
//                         sum +
//                         (product.discount.type === "fixed"
//                             ? product.discount.amount
//                             : product.price *
//                               product.quantity *
//                               (product.discount.amount / 100))
//                     );
//                 }
//                 return sum;
//             },
//             0
//         );

//         let transactionDiscAmount = 0;
//         if (transactionDiscount.amount > 0) {
//             transactionDiscAmount =
//                 transactionDiscount.type === "fixed"
//                     ? transactionDiscount.amount
//                     : (subtotal - totalProductDiscounts) *
//                       (transactionDiscount.amount / 100);
//         }

//         const total = Math.max(
//             0,
//             subtotal - totalProductDiscounts - transactionDiscAmount
//         );

//         const productsToSend = selectedProducts.map((p) => {
//             let productDiscount = 0;
//             if (p.discount && p.discount.amount > 0) {
//                 productDiscount =
//                     p.discount.type === "fixed"
//                         ? p.discount.amount
//                         : p.price * (p.discount.amount / 100);
//             }

//             const priceAfterDiscount = Math.max(0, p.price - productDiscount);
//             const itemSubtotal = priceAfterDiscount * p.quantity;

//             return {
//                 product_id: p.id,
//                 quantity: p.quantity,
//                 price: p.price,
//                 cost: p.cost || 0,
//                 discount: productDiscount,
//                 subtotal: itemSubtotal,
//                 is_modal_real: true,
//             };
//         });

//         const payNowBtn = document.getElementById("pay-now");
//         const originalBtnText = payNowBtn.innerHTML;
//         payNowBtn.disabled = true;
//         payNowBtn.innerHTML =
//             '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

//         const form = document.createElement("form");
//         form.method = "POST";
//         form.action = "/kasir/transaksi/store";

//         const csrfToken = document
//             .querySelector('meta[name="csrf-token"]')
//             ?.getAttribute("content");
//         if (!csrfToken) {
//             alert("CSRF token tidak ditemukan. Silakan refresh halaman.");
//             resetButton();
//             return;
//         }

//         const csrfInput = document.createElement("input");
//         csrfInput.type = "hidden";
//         csrfInput.name = "_token";
//         csrfInput.value = csrfToken;
//         form.appendChild(csrfInput);

//         productsToSend.forEach((product, index) => {
//             for (const key in product) {
//                 const input = document.createElement("input");
//                 input.type = "hidden";
//                 input.name = `products[${index}][${key}]`;
//                 input.value = product[key];
//                 form.appendChild(input);
//             }
//         });

//         const addInput = (name, value) => {
//             const input = document.createElement("input");
//             input.type = "hidden";
//             input.name = name;
//             input.value = value;
//             form.appendChild(input);
//         };

//         addInput("subtotal", subtotal);
//         addInput("total", total);
//         addInput(
//             "discount_amount",
//             totalProductDiscounts + transactionDiscAmount
//         );
//         addInput("transaction_discount[type]", transactionDiscount.type);
//         addInput("transaction_discount[amount]", transactionDiscount.amount);

//         const customerName =
//             document.getElementById("customer_name")?.value ?? null;
//         if (customerName) {
//             addInput("customer_name", customerName);
//         }

//         document.body.appendChild(form);
//         form.submit();

//         function resetButton() {
//             payNowBtn.disabled = false;
//             payNowBtn.innerHTML = originalBtnText;
//         }
//     }

//     function holdTransaction() {
//         if (selectedProducts.length === 0) {
//             alert("Tidak ada produk yang dipilih");
//             return;
//         }
//         alert("Fungsi hold transaksi akan diimplementasikan disini");
//     }

//     function cancelTransaction() {
//         if (selectedProducts.length === 0) {
//             alert("Tidak ada produk yang dipilih");
//             return;
//         }
//         if (confirm("Apakah Anda yakin ingin membatalkan transaksi ini?")) {
//             selectedProducts = [];
//             document
//                 .querySelectorAll(".product-row")
//                 .forEach((row) => row.remove());
//             document.querySelectorAll(".product-card").forEach((card) => {
//                 card.classList.remove(
//                     "selected",
//                     "click-selected",
//                     "scan-selected"
//                 );
//                 const cartIndicator = card.querySelector(".cart-indicator");
//                 if (cartIndicator) cartIndicator.classList.add("hidden");
//             });

//             const container = document.getElementById("selected-products");
//             container.innerHTML = `<div class="p-4 text-center text-gray-500 no-products">Belum ada produk dipilih</div>`;

//             transactionDiscount = {
//                 amount: 0,
//                 type: "fixed",
//             };
//             document.getElementById("discount-amount").value = "";
//             document.getElementById("discount-type").value = "fixed";
//             discountContainer.classList.add("hidden");
//             document.getElementById("discount-label").textContent =
//                 "Tambah Diskon";
//             discountArrow.classList.remove("rotate-180");
//             updateTotals();
//         }
//     }

//     let scanningPaused = false;

//     function initScanner() {
//         const config = {
//             inputStream: {
//                 name: "Live",
//                 type: "LiveStream",
//                 target: document.querySelector("#interactive"),
//                 constraints: {
//                     width: {
//                         ideal: 640,
//                     },
//                     height: {
//                         ideal: 480,
//                     },
//                     facingMode: "environment",
//                 },
//             },
//             locator: {
//                 patchSize: "large",
//                 halfSample: false,
//             },
//             numOfWorkers: navigator.hardwareConcurrency || 4,
//             frequency: 50,
//             decoder: {
//                 readers: [
//                     "ean_reader",
//                     "ean_8_reader",
//                     "code_128_reader",
//                     "code_39_reader",
//                     "code_39_vin_reader",
//                     "codabar_reader",
//                     "upc_reader",
//                     "upc_e_reader",
//                 ],
//                 multiple: false,
//             },
//             locate: true,
//             debug: false,
//         };

//         Quagga.init(config, function (err) {
//             if (err) {
//                 console.error(err);
//                 alert("Scanner gagal dimulai");
//                 return;
//             }
//             Quagga.start();
//         });

//         Quagga.onDetected(function (result) {
//             const code = result.codeResult.code;
//             console.log("Scanned code:", code);

//             if (scanningPaused) return;

//             handleBarcodeDetection({
//                 codeResult: {
//                     code,
//                 },
//             });
//         });
//     }

//     async function handleBarcodeDetection(result) {
//         let code = result.codeResult.code?.trim();
//         if (!code) return;

//         console.log("Scanned code:", code);

//         let productCard = document.querySelector(
//             `.product-card[data-barcode="${code}"], .product-card[data-id="${code}"]`
//         );

//         if (productCard) {
//             const productId = productCard.dataset.id;
//             selectProduct(productId, "scan");
//             playBeepSound();

//             scanningPaused = true;
//             setTimeout(() => {
//                 scanningPaused = false;
//             }, 2000);

//             return;
//         }

//         try {
//             const response = await fetch(
//                 `/api/products/find?barcode=${encodeURIComponent(code)}`
//             );
//             if (response.ok) {
//                 const product = await response.json();

//                 if (product) {
//                     const added = selectProduct(product.id, "scan");
//                     if (added) {
//                         playBeepSound();
//                     } else {
//                         alert(
//                             `Produk "${product.name}" ditambahkan meskipun tidak terlihat di daftar saat ini`
//                         );
//                         addProductToTable(product);
//                         playBeepSound();
//                     }

//                     scanningPaused = true;
//                     setTimeout(() => {
//                         scanningPaused = false;
//                     }, 2000);

//                     return;
//                 }
//             }
//         } catch (e) {
//             console.error("Error checking product:", e);
//         }
//     }

//     function playBeepSound() {
//         try {
//             const audioCtx = new (window.AudioContext ||
//                 window.webkitAudioContext)();
//             const oscillator = audioCtx.createOscillator();
//             const gainNode = audioCtx.createGain();

//             oscillator.connect(gainNode);
//             gainNode.connect(audioCtx.destination);

//             oscillator.type = "sine";
//             oscillator.frequency.value = 800;
//             gainNode.gain.value = 0.1;

//             oscillator.start();
//             gainNode.gain.exponentialRampToValueAtTime(
//                 0.00001,
//                 audioCtx.currentTime + 0.1
//             );
//             oscillator.stop(audioCtx.currentTime + 0.1);
//         } catch (e) {
//             console.log("Audio error:", e);
//         }
//     }

//     window.addEventListener("beforeunload", function () {
//         if (Quagga) {
//             Quagga.offDetected(handleBarcodeDetection);
//             Quagga.stop();
//         }
//     });
// });


$(document).ready(function () {
    const $discountToggle = $("#discount-toggle");
    const $discountContainer = $("#discount-container");
    const $discountArrow = $("#discount-arrow");
    const $applyDiscountBtn = $("#apply-transaction-discount");
    const $payNowBtn = $("#pay-now");
    const $holdTransactionBtn = $("#hold-transaction");
    const $cancelTransactionBtn = $("#cancel-transaction");
    const $selectedProductsContainer = $("#selected-products");

    let selectedProducts = [];
    let transactionDiscount = {
        amount: 0,
        type: "fixed",
    };
    let scanningPaused = false;

    initScanner();

    $discountToggle.on("click", toggleDiscountDisplay);
    $applyDiscountBtn.on("click", applyTransactionDiscount);
    
    $payNowBtn.on("click", processPayment);
    $holdTransactionBtn.on("click", holdTransaction);
    $cancelTransactionBtn.on("click", cancelTransaction);

    $(".product-card").on("click", function () {
        const productId = $(this).data("id");
        selectProduct(productId, "click");
    });

    function toggleDiscountDisplay() {
        $discountContainer.toggleClass("hidden");
        const isHidden = $discountContainer.hasClass("hidden");
        $("#discount-label").text(isHidden ? "Tambah Diskon" : "Tutup Diskon");
        $discountArrow.toggleClass("rotate-180");
    }

    function applyTransactionDiscount() {
        const amount = parseFloat($("#discount-amount").val()) || 0;
        const type = $("#discount-type").val();

        transactionDiscount = {
            amount,
            type,
        };
        updateTotals();

        $discountContainer.addClass("hidden");
        $("#discount-label").text("Tambah Diskon");
        $discountArrow.removeClass("rotate-180");
    }

    function selectProduct(productId, source = "click") {
        const $productCard = $(`.product-card[data-id="${productId}"]`);
        if ($productCard.length === 0) {
            console.log("Product not found in DOM");
            return false;
        }
        
        const product = {
            id: productId,
            name: $productCard.data("name"),
            price: parseFloat($productCard.data("price")),
            cost: parseFloat($productCard.data("cost")),
            category: $productCard.data("category"),
            stock: parseInt($productCard.data("stock")),
            barcode: $productCard.data("barcode") || null,
        };

        const existingProduct = selectedProducts.find(p => p.id === productId);

        if (existingProduct) {
            existingProduct.quantity += 1;
            existingProduct.subtotal = calculateSubtotal(existingProduct);
            updateProductRow(productId);
        } else {
            addProductToTable(product);
        }

        $productCard.find(".cart-indicator").removeClass("hidden");

        if (source === "click") {
            $productCard.addClass("click-selected");
            setTimeout(() => {
                $productCard.removeClass("click-selected");
            }, 500);
        } else {
            $productCard.addClass("scan-selected");
            setTimeout(() => {
                $productCard.removeClass("scan-selected");
            }, 1000);
        }

        return true;
    }

    function addProductToTable(product) {
        $selectedProductsContainer.find(".no-products").remove();

        const $newRow = $("#product-row-template").contents().clone();
        $newRow.attr("data-id", product.id);

        $newRow.find(".product-name").text(product.name);
        $newRow.find(".product-code").text(product.barcode ? `# ${product.barcode}` : `# ${product.id}`);
        $newRow.find(".product-subtotal").text(formatCurrency(product.price));

        $selectedProductsContainer.append($newRow);

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

        setupProductRowEvents($newRow, product.id);
        updateTotals();
    }

    function setupProductRowEvents($row, productId) {
        const $quantityInput = $row.find(".quantity-input");
        const $decreaseBtn = $row.find(".decrease-qty");
        const $increaseBtn = $row.find(".increase-qty");
        const $removeBtn = $row.find(".remove-product");
        const $toggleDiscountBtn = $row.find(".toggle-discount");
        const $applyDiscountBtn = $row.find(".apply-discount");
        const $discountContainer = $row.find(".product-discount-container");
        const $discountAmountInput = $row.find(".item-discount-amount");
        const $discountTypeSelect = $row.find(".item-discount-type");
        const $discountDisplay = $row.find(".product-discount-display");

        const handleQuantityChange = () => {
            const newQuantity = parseInt($quantityInput.val()) || 1;
            updateProductQuantity(productId, newQuantity);
        };

        $quantityInput.on("change blur", handleQuantityChange);

        $decreaseBtn.on("click", () => {
            const currentQty = parseInt($quantityInput.val());
            if (currentQty > 1) {
                $quantityInput.val(currentQty - 1).trigger("change");
            }
        });

        $increaseBtn.on("click", () => {
            const currentQty = parseInt($quantityInput.val());
            $quantityInput.val(currentQty + 1).trigger("change");
        });

        $removeBtn.on("click", () => removeProduct(productId));

        $toggleDiscountBtn.on("click", function () {
            $discountContainer.toggleClass("hidden");
            $(this).find("svg").toggleClass("rotate-180");
        });

        $applyDiscountBtn.on("click", function () {
            const discountAmount = parseFloat($discountAmountInput.val()) || 0;
            const discountType = $discountTypeSelect.val();
            updateProductDiscount(productId, discountAmount, discountType);

            $discountContainer.addClass("hidden");
            $toggleDiscountBtn.find("svg").removeClass("rotate-180");

            if (discountAmount > 0) {
                $discountDisplay.removeClass("hidden");
                $discountDisplay.find(".discount-amount").text(
                    discountType === "fixed"
                        ? "Rp " + discountAmount.toLocaleString("id-ID")
                        : discountAmount + "%"
                );
            } else {
                $discountDisplay.addClass("hidden");
            }
        });
    }

    function updateProductRow(productId) {
        const product = selectedProducts.find(p => p.id === productId);
        const $row = $(`.product-row[data-id="${productId}"]`);
        
        if (product && $row.length) {
            $row.find(".product-subtotal").text(formatCurrency(product.subtotal));
            $row.find(".quantity-input").val(product.quantity);
        }
        
        updateTotals();
    }

    function updateProductQuantity(productId, newQuantity) {
        const product = selectedProducts.find(p => p.id === productId);
        if (product) {
            product.quantity = newQuantity;
            product.subtotal = calculateSubtotal(product);
            updateProductRow(productId);
        }
    }

    function updateProductDiscount(productId, amount, type) {
        const product = selectedProducts.find(p => p.id === productId);
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
        selectedProducts = selectedProducts.filter(p => p.id !== productId);
        
        $(`.product-row[data-id="${productId}"]`).remove();

        const $productCard = $(`.product-card[data-id="${productId}"]`);
        if ($productCard.length) {
            $productCard.removeClass("selected click-selected scan-selected");
            $productCard.find(".cart-indicator").addClass("hidden");
        }

        if ($selectedProductsContainer.children().length === 0) {
            $selectedProductsContainer.html('<div class="p-4 text-center text-gray-500 no-products">Belum ada produk dipilih</div>');
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
                    return sum + (
                        product.discount.type === "fixed"
                            ? product.discount.amount
                            : product.price * product.quantity * (product.discount.amount / 100)
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
                    : (subtotal - totalProductDiscounts) * (transactionDiscount.amount / 100);
        }

        const total = Math.max(0, subtotal - totalProductDiscounts - transactionDiscAmount);

        $("#subtotal").text(formatCurrency(subtotal));
        $("#subtotal-discount").text(formatCurrency(transactionDiscAmount));
        $("#total-discount").text(formatCurrency(totalProductDiscounts + transactionDiscAmount));
        $("#total-amount").text(formatCurrency(total));
    }

    function formatCurrency(amount) {
        return "Rp" + amount.toFixed(0).replace(/\d(?=(\d{3})+$)/g, "$&.");
    }

    function processPayment() {
        if (selectedProducts.length === 0) {
            alert("Tidak ada produk yang dipilih");
            return;
        }

        const subtotal = selectedProducts.reduce(
            (sum, product) => sum + product.price * product.quantity,
            0
        );

        const totalProductDiscounts = selectedProducts.reduce(
            (sum, product) => {
                if (product.discount && product.discount.amount > 0) {
                    return sum + (
                        product.discount.type === "fixed"
                            ? product.discount.amount
                            : product.price * product.quantity * (product.discount.amount / 100)
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
                    : (subtotal - totalProductDiscounts) * (transactionDiscount.amount / 100);
        }

        const total = Math.max(0, subtotal - totalProductDiscounts - transactionDiscAmount);

        const productsToSend = selectedProducts.map(p => {
            let productDiscount = 0;
            if (p.discount && p.discount.amount > 0) {
                productDiscount =
                    p.discount.type === "fixed"
                        ? p.discount.amount
                        : p.price * (p.discount.amount / 100);
            }

            const priceAfterDiscount = Math.max(0, p.price - productDiscount);
            const itemSubtotal = priceAfterDiscount * p.quantity;

            return {
                product_id: p.id,
                quantity: p.quantity,
                price: p.price,
                cost: p.cost || 0,
                discount: productDiscount,
                subtotal: itemSubtotal,
                is_modal_real: true,
            };
        });

        const originalBtnText = $payNowBtn.html();
        $payNowBtn.prop("disabled", true);
        $payNowBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');

        const $form = $("<form>")
            .attr("method", "POST")
            .attr("action", "/kasir/transaksi/store");

        const csrfToken = $('meta[name="csrf-token"]').attr("content");
        if (!csrfToken) {
            alert("CSRF token tidak ditemukan. Silakan refresh halaman.");
            resetButton();
            return;
        }

        $("<input>")
            .attr({
                type: "hidden",
                name: "_token",
                value: csrfToken
            })
            .appendTo($form);

        productsToSend.forEach((product, index) => {
            for (const key in product) {
                $("<input>")
                    .attr({
                        type: "hidden",
                        name: `products[${index}][${key}]`,
                        value: product[key]
                    })
                    .appendTo($form);
            }
        });

        const addInput = (name, value) => {
            $("<input>")
                .attr({
                    type: "hidden",
                    name: name,
                    value: value
                })
                .appendTo($form);
        };

        addInput("subtotal", subtotal);
        addInput("total", total);
        addInput("discount_amount", totalProductDiscounts + transactionDiscAmount);
        addInput("transaction_discount[type]", transactionDiscount.type);
        addInput("transaction_discount[amount]", transactionDiscount.amount);

        const customerName = $("#customer_name").val() || null;
        if (customerName) {
            addInput("customer_name", customerName);
        }

        $form.appendTo("body").submit();

        function resetButton() {
            $payNowBtn.prop("disabled", false);
            $payNowBtn.html(originalBtnText);
        }
    }

    function cancelTransaction() {
        if (selectedProducts.length === 0) {
            alert("Tidak ada produk yang dipilih");
            return;
        }
        
        if (confirm("Apakah Anda yakin ingin membatalkan transaksi ini?")) {
            selectedProducts = [];
            
            $(".product-row").remove();
            $(".product-card").removeClass("selected click-selected scan-selected");
            $(".product-card .cart-indicator").addClass("hidden");
            
            $selectedProductsContainer.html('<div class="p-4 text-center text-gray-500 no-products">Belum ada produk dipilih</div>');

            transactionDiscount = {
                amount: 0,
                type: "fixed",
            };
            
            $("#discount-amount").val("");
            $("#discount-type").val("fixed");
            $discountContainer.addClass("hidden");
            $("#discount-label").text("Tambah Diskon");
            $discountArrow.removeClass("rotate-180");
            
            updateTotals();
        }
    }
    
    function initScanner() {
        const config = {
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector("#interactive"),
                constraints: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
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
                codeResult: { code }
            });
        });
    }

    async function handleBarcodeDetection(result) {
        let code = result.codeResult.code?.trim();
        if (!code) return;

        console.log("Scanned code:", code);

        let $productCard = $(`.product-card[data-barcode="${code}"], .product-card[data-id="${code}"]`);

        if ($productCard.length) {
            const productId = $productCard.data("id");
            selectProduct(productId, "scan");
            playBeepSound();

            scanningPaused = true;
            setTimeout(() => {
                scanningPaused = false;
            }, 2000);

            return;
        }

        try {
            const response = await $.ajax({
                url: `/api/products/find?barcode=${encodeURIComponent(code)}`,
                type: "GET"
            });

            if (response) {
                const added = selectProduct(response.id, "scan");
                if (added) {
                    playBeepSound();
                } else {
                    alert(`Produk "${response.name}" ditambahkan meskipun tidak terlihat di daftar saat ini`);
                    addProductToTable(response);
                    playBeepSound();
                }

                scanningPaused = true;
                setTimeout(() => {
                    scanningPaused = false;
                }, 2000);
            }
        } catch (e) {
            console.error("Error checking product:", e);
        }
    }

    function playBeepSound() {
        try {
            const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
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
    }

    $(window).on("beforeunload", function () {
        if (typeof Quagga !== "undefined") {
            Quagga.offDetected(handleBarcodeDetection);
            Quagga.stop();
        }
    });
});