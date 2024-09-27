jQuery(document).ready(function($) {

    $('.add_product').on('click', function(e) {
        e.preventDefault();
        var selectedProductId = $('#selected_product').val();
        
        
        // Make an AJAX call

        $.ajax({

            url: my_ajax_object.ajax_url,  // This will point to admin-ajax.php

            type: 'POST',

            data: {

                action: 'my_custom_ajax_action', // The PHP function to run

                nonce: my_ajax_object.nonce,    // Security nonce

                post_id: selectedProductId

            },

            success: function(response) {

                // alert('Success: ' + response.data); // Show the response from PHP
                // console.log(response);
                $('.order-form').append(response.data)
                

            },

            error: function(response) {

                alert('Error: ' + response.responseText); // Handle any errors

            }

        });

    });
    // add to cart aggregate items
    $('.get_product').on('change', function(e) {
        e.preventDefault();
        var selectedProductId = $('#selected_product').val();
        
        
        // Make an AJAX call

        $.ajax({

            url: my_ajax_object.ajax_url,  // This will point to admin-ajax.php

            type: 'POST',

            data: {

                action: 'my_custom_ajax_action', // The PHP function to run

                nonce: my_ajax_object.nonce,    // Security nonce

                post_id: selectedProductId

            },

            success: function(response) {

                // alert('Success: ' + response.data); // Show the response from PHP
                // console.log(response);
                $('.order-form').append(response.data)
                

            },

            error: function(response) {

                alert('Error: ' + response.responseText); // Handle any errors

            }

        });

    });



    var button = document.getElementById('addProductsButton');

    var childProductsList = document.querySelector('.grouped-product-children');

    var hrLine = document.getElementById('horizontal__line');



    // Initially hide the child products list (for safety, but it should already be hidden)

    childProductsList.style.display = 'none';



    button.addEventListener('click', function() {

        // Check if the child products list is currently hidden

        if (getComputedStyle(childProductsList).display === 'none') {

            childProductsList.style.display = 'block';  

            button.style.display = 'none';               

            hrLine.style.marginTop = '100px';           

            console.log('aaa');                        

        }

    });

    
});



///////////////////CHECKOUT BUTTON//////////////////////
// document.addEventListener('DOMContentLoaded', function() {
//     const tncCheckbox = document.querySelector('input[name="tnc"]'); 
//     const checkoutButton = document.querySelector('.wc-bookings-booking-form-button'); 
//     const bookingCost = document.querySelector('.wc-bookings-booking-cost'); 

//     function toggleCheckoutButton() {
//         const isTncChecked = tncCheckbox.checked; 

//         const isBookingCostVisible = bookingCost && bookingCost.offsetParent !== null; 

//         if (isTncChecked && isBookingCostVisible) {
//             checkoutButton.removeAttribute('disabled');
//             checkoutButton.classList.remove('disabled');
//             checkoutButton.style.textTransform = 'uppercase';
            
//         } else {
//             checkoutButton.setAttribute('disabled', 'disabled');
//             checkoutButton.classList.add('disabled');
//         }
//     }

//     toggleCheckoutButton();

//     tncCheckbox.addEventListener('change', toggleCheckoutButton);

//     new MutationObserver(toggleCheckoutButton).observe(bookingCost, { attributes: true, attributeFilter: ['style'] });
// });






document.getElementById('custom_image_upload').addEventListener('change', function() {

  var fileName = this.files[0].name;

  document.querySelector('.file-chosen').textContent = fileName;

});


// Aggregate Product template

// function changeVolume(event, delta) {

//     const input = event.target.closest('.volume-input').querySelector('input[type="text"]');

//     let currentValue = parseInt(input.value);

//     currentValue += delta;

//     if (currentValue < 1) currentValue = 1; // Prevent negative or zero volume

//     input.value = currentValue;

// }



// function removeRow(button) {

//     const row = button.closest('.order-row');

//     row.remove();

// }

