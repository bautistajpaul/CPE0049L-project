function setMinDateTime() {
    var now = new Date();
    var year = now.getFullYear();
    var month = ('0' + (now.getMonth() + 1)).slice(-2);
    var day = ('0' + now.getDate()).slice(-2);
    var hours = ('0' + now.getHours()).slice(-2);
    var minutes = ('0' + now.getMinutes()).slice(-2);

    var minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

    document.getElementById('preferredDateTime').setAttribute('min', minDateTime);
}

setMinDateTime();

// Modal handling
var modal = document.getElementById('termsModal');
var termsLink = document.querySelector('.terms-link');
var closeModalButtons = document.querySelectorAll('.close-modal');

// Show the modal when the terms link is clicked
termsLink.onclick = function() {
    modal.style.display = 'block';
};

// Close the modal when any close button is clicked
closeModalButtons.forEach(button => {
    button.onclick = function() {
        modal.style.display = 'none';
    }
});

// Close the modal when the user clicks outside the modal content
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

// Enable "Proceed to Payment" button when terms are agreed in the modal
var termsAgreeMain = document.getElementById('termsAgreeMain');
var termsAgreeModal = document.getElementById('termsAgreeModal');
var proceedToPaymentButton = document.getElementById('proceedToPayment');

termsAgreeModal.addEventListener('change', function() {
    if (termsAgreeModal.checked) {
        termsAgreeMain.checked = true;
        proceedToPaymentButton.style.display = 'inline-block';
        modal.style.display = 'none'; // Automatically close the modal
    } else {
        termsAgreeMain.checked = false;
        proceedToPaymentButton.style.display = 'none';
    }
});



