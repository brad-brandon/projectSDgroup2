document.querySelectorAll('.membership-option').forEach(option => {
    option.addEventListener('click', function() {
        // Remove 'selected' class from all options
        document.querySelectorAll('.membership-option').forEach(el => el.classList.remove('selected'));

        // Add 'selected' class to the clicked option
        this.classList.add('selected');

        // Select the radio button associated with this option
        this.querySelector('input[type="radio"]').checked = true;
    });
});

//func untuk handle form submmission
document.getElementById('membershipForm').addEventListener('submit', function(event){
    event.preventDefault();

    const selectedMembership = document.querySelector('input[name="membership"]:checked');

    if (selectedMembership) {
        // direct to payment.html ikut user input apa
        const membershipValue = selectedMembership.value;
        window.location.href = `payment.html?membership=${membershipValue}`;
    } else {
        //alert user kalau input salah
        alert('Please select a membership option.');
    }
});