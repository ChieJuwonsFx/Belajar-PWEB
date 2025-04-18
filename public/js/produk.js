// (function($) {
//     $.initProductImageUpload = function(productId = '') {
//         const prefix = productId ? `${productId}-` : '';
//         const $imageInput = $(`#imageInput-${prefix}`);
//         const $previewContainer = $(`#previewContainer-${prefix}`);
//         const $imagesJsonInput = $(`#imagesJsonInput-${prefix}`);

//         let imageList = [];
//         try {
//             imageList = JSON.parse($imagesJsonInput.val() || '[]');
//         } catch (e) {
//             imageList = [];
//         }

//         $imageInput.off('change').on('change', function() {
//             const files = this.files;
//             if (!files || files.length === 0) return;

//             $.each(files, function(i, file) {
//                 const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
//                 if (!validTypes.includes(file.type)) {
//                     alert("File harus berupa gambar (jpg, jpeg, png, webp)");
//                     return true;
//                 }

//                 if (file.size > 2 * 1024 * 1024) {
//                     alert("Ukuran maksimal 2MB");
//                     return true;
//                 }

//                 const reader = new FileReader();
//                 reader.onload = function(e) {
//                     const base64 = e.target.result;
//                     imageList.push(base64);
//                     $imagesJsonInput.val(JSON.stringify(imageList));

//                     const $card = $(`
//                         <div class="relative rounded-lg overflow-hidden shadow-md group">
//                             <img src="${base64}" class="w-full h-40 object-cover">
//                             <button type="button" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition" 
//                                     onclick="$.removeProductImage(this, '${productId}')">
//                                 &times;
//                             </button>
//                         </div>
//                     `);

//                     $previewContainer.find('label[for^="imageInput"]').before($card);
//                 };
//                 reader.readAsDataURL(file);
//             });

//             $(this).val('');
//         });
//     };

//     $.removeProductImage = function(button, productId = '') {
//         const prefix = productId ? `${productId}-` : '';
//         const $card = $(button).parent();
//         const imgSrc = $card.find('img').attr('src');
//         const $imagesJsonInput = $(`#imagesJsonInput-${prefix}`);
        
//         let imageList = [];
//         try {
//             imageList = JSON.parse($imagesJsonInput.val() || '[]');
//         } catch (e) {
//             imageList = [];
//         }
        
//         imageList = imageList.filter(src => src !== imgSrc);
//         $imagesJsonInput.val(JSON.stringify(imageList));
        
//         $card.remove();
//     };
// })(jQuery);

// $(document).ready(function() {
//     $('[id^="edit-produk-"]').on('shown.bs.modal', function() {
//         const productId = this.id.replace('edit-produk-', '');
//         $.initProductImageUpload(productId);
//     });

//     $('#add-produk').on('shown.bs.modal', function() {
//         $.initProductImageUpload();
//     });
// });