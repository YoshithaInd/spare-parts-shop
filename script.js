// ===== MEMBER 4: JS Validation =====
document.addEventListener('DOMContentLoaded', function () {

    // Validate Add Part form
    const partForm = document.getElementById('partForm');
    if (partForm) {
        partForm.addEventListener('submit', function (e) {
            const name = document.getElementById('part_name').value.trim();
            const make = document.getElementById('vehicle_make').value.trim();
            const price = document.getElementById('price').value.trim();

            if (name === '' || make === '' || price === '') {
                alert('Please fill in Part Name, Vehicle Make, and Price.');
                e.preventDefault();
            }
        });
    }

    // Validate Checkout form + simple card number formatting
    const checkoutForm = document.getElementById('checkoutForm');
    if (checkoutForm) {
        const cardInput = document.getElementById('card_number');

        cardInput.addEventListener('input', function () {
            let value = cardInput.value.replace(/\D/g, '').slice(0, 16);
            cardInput.value = value.replace(/(.{4})/g, '$1 ').trim();
        });

        checkoutForm.addEventListener('submit', function (e) {
            const name = document.getElementById('customer_name').value.trim();
            const email = document.getElementById('customer_email').value.trim();
            const address = document.getElementById('customer_address').value.trim();
            const card = cardInput.value.replace(/\s/g, '');

            if (name === '' || email === '' || address === '') {
                alert('Please fill in all your details.');
                e.preventDefault();
                return;
            }
            if (card.length < 12) {
                alert('Please enter a valid card number.');
                e.preventDefault();
            }
        });
    }
});
