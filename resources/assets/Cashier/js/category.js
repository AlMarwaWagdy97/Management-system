// ... existing code ...
document.addEventListener("DOMContentLoaded", function() {
  // Get the saved card index from localStorage
  const selectedIndex = localStorage.getItem('selectedCardIndex');
  if (selectedIndex !== null) {
    // Get all cards in the section
    const cards = document.querySelectorAll('.sections .Card');
    cards.forEach((card, idx) => {
      if (idx == selectedIndex) {
        card.parentElement.style.display = 'block'; // Show the selected card
      } else {
        card.parentElement.style.display = 'none'; // Hide others
      }
    });
  }
});


document.querySelectorAll('.btn-add i.fa-cart-plus').forEach(function(btn){
  btn.closest('button').addEventListener('click', function(e){
    document.getElementById('cartSuccessModal').style.display = 'flex';
  });
});
// Optional: Close modal when clicking outside content
document.getElementById('cartSuccessModal').addEventListener('click', function(e) {
  if (e.target === this) this.style.display = 'none';
});