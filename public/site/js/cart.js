document.addEventListener('DOMContentLoaded', function() {
    const checkoutBtn = document.querySelector('.cart-checkout-btn');
    const cartForm = document.querySelector('.cart-form');
    if (checkoutBtn && cartForm) {
      cartForm.style.display = 'none';
      checkoutBtn.addEventListener('click', function() {
        cartForm.style.display = 'flex';
      });
    }



  // Get all payment method images
  const paymentImages = document.querySelectorAll('.payment-methods .img-container img');
  
  // Get all payment content sections
  const paymentContents = document.querySelectorAll('.payment-content');
  
 
  
  // Add click event listeners to each payment image
  paymentImages.forEach((img, index) => {
    img.addEventListener('click', function() {
      // Hide all payment-content
      document.querySelectorAll('.payment-content').forEach(content => {
        content.style.display = 'none';
      });
      
      // Show the corresponding payment-content
      if (document.querySelectorAll('.payment-content')[index]) {
        document.querySelectorAll('.payment-content')[index].style.display = 'block';
      }
      
      // Remove active class from all images
      paymentImages.forEach(img => img.classList.remove('active'));
      
      // Add active class to clicked image
      this.classList.add('active');
      
      // Hide all payment contents
      paymentContents.forEach(content => content.classList.remove('active'));
      
      // Show the corresponding payment content
      if (paymentContents[index]) {
        paymentContents[index].classList.add('active');
      }
      
      // If third image (bank transfer) is clicked, show all bank forms
    });
  });
});

