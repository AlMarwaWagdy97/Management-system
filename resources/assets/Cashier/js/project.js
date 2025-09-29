// Gift form functionality
document.addEventListener('DOMContentLoaded', function() {
  // Toggle gift container visibility when checkbox is clicked
  const giftCheckbox = document.getElementById('gift_checkbox');
  const giftContainer = document.getElementById('gift_container');
  
  if (giftCheckbox && giftContainer) {
    giftCheckbox.addEventListener('change', function() {
      if (this.checked) {
        giftContainer.style.display = 'block';
      } else {
        giftContainer.style.display = 'none';
        // Remove all additional gift forms when main gift checkbox is unchecked
        const additionalForms = document.querySelectorAll('.additional-gift-container');
        additionalForms.forEach(form => form.remove());
      }
    });
  }
  
  // Handle gift category selection
  const giftCategorySelect = document.getElementById('gift_category');
  const giftCardsContainer = document.getElementById('gift_cards_container');
  
  if (giftCategorySelect && giftCardsContainer) {
    giftCategorySelect.addEventListener('change', function() {
      if (this.value) {
        giftCardsContainer.style.display = 'block';
      } else {
        giftCardsContainer.style.display = 'none';
      }
    });
  }
  
  // Handle "Add another gift" button
  const addAnotherGiftBtn = document.getElementById('add_another_gift');
  if (addAnotherGiftBtn) {
    let giftFormCount = 1;
    
    addAnotherGiftBtn.addEventListener('click', function() {
      giftFormCount++;
      
      // Create a new gift container
      const newGiftContainer = document.createElement('div');
      newGiftContainer.className = 'gift-container additional-gift-container';
      newGiftContainer.id = `gift_container_${giftFormCount}`;
      
      // Add a separator and remove button
      const separatorDiv = document.createElement('div');
      separatorDiv.className = 'gift-separator';
      separatorDiv.innerHTML = `
        <hr>
        <div class="gift-header-with-actions">
          <h4>بيانات المهدى إليه ${giftFormCount}</h4>
          <button type="button" class="remove-gift-btn" data-form-id="${giftFormCount}">
            <i class="fa-solid fa-times"></i> إزالة
          </button>
        </div>
      `;
      
      // Clone the gift form content
      const originalForm = document.querySelector('.gift-form').cloneNode(true);
      
      // Update IDs to make them unique
      const formInputs = originalForm.querySelectorAll('input, select');
      formInputs.forEach(input => {
        if (input.id) {
          const newId = `${input.id}_${giftFormCount}`;
          const label = originalForm.querySelector(`label[for="${input.id}"]`);
          if (label) {
            label.setAttribute('for', newId);
          }
          input.id = newId;
          
          // Clear input values
          if (input.type === 'text' || input.type === 'email' || input.type === 'tel') {
            input.value = '';
          } else if (input.type === 'checkbox' || input.type === 'radio') {
            input.checked = false;
          } else if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
          }
        }
      });
      
      // Remove the "Add another gift" button from the cloned form
      const addButtonDiv = originalForm.querySelector('.text-center');
      if (addButtonDiv) {
        // Replace removeChild with remove() method on the element itself
        addButtonDiv.remove();
      }
      
      // Add the content to the new container
      newGiftContainer.appendChild(separatorDiv);
      
      // Clone the donation amount section
      const originalDonationSection = document.querySelector('.gift-donation-section').cloneNode(true);
      const donationButtons = originalDonationSection.querySelectorAll('.donation-amount-btn');
      donationButtons.forEach(btn => btn.classList.remove('active'));
      const amountInput = originalDonationSection.querySelector('input');
      if (amountInput) amountInput.value = '';
      
      newGiftContainer.appendChild(originalDonationSection);
      newGiftContainer.appendChild(originalForm);
      
      // Add the new container after the last gift container
      const lastGiftContainer = document.querySelector('.gift-container:last-of-type');
      if (lastGiftContainer) {
        lastGiftContainer.after(newGiftContainer);
      } else {
        // Fallback: append to the parent of the original container
        const parentContainer = document.getElementById('gift_container').parentNode;
        parentContainer.appendChild(newGiftContainer);
      }
      
      // Add event listener for the remove button
      const removeBtn = newGiftContainer.querySelector('.remove-gift-btn');
      if (removeBtn) {
        removeBtn.addEventListener('click', function() {
          const formId = this.getAttribute('data-form-id');
          const formToRemove = document.getElementById(`gift_container_${formId}`);
          if (formToRemove) {
            formToRemove.remove();
          }
        });
      }
      
      // Add event listener for the new gift category select
      const newCategorySelect = newGiftContainer.querySelector('.gift-category-select');
      const newCardsContainer = newGiftContainer.querySelector('.gift-cards-container');
      if (newCategorySelect && newCardsContainer) {
        newCategorySelect.addEventListener('change', function() {
          if (this.value) {
            newCardsContainer.style.display = 'block';
          } else {
            newCardsContainer.style.display = 'none';
          }
        });
      }
      
      // Add event listeners for donation amount buttons
      const newDonationButtons = newGiftContainer.querySelectorAll('.donation-amount-btn');
      if (newDonationButtons.length > 0) {
        newDonationButtons.forEach(button => {
          button.addEventListener('click', function() {
            // Remove active class from all buttons in this container
            newDonationButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            // Clear the custom amount input in this container
            const otherAmountInput = newGiftContainer.querySelector('.other-amount-input input');
            if (otherAmountInput) {
              otherAmountInput.value = '';
            }
          });
        });
      }
    });
  }
  
  // Handle donation amount button selection for the first form
  const donationButtons = document.querySelectorAll('.donation-amount-btn');
  if (donationButtons.length > 0) {
    donationButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Find all buttons within the same container
        const container = this.closest('.gift-donation-section');
        const containerButtons = container.querySelectorAll('.donation-amount-btn');
        
        // Remove active class from all buttons in this container
        containerButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        this.classList.add('active');
        
        // Clear the custom amount input in this container
        const otherAmountInput = container.querySelector('.other-amount-input input');
        if (otherAmountInput) {
          otherAmountInput.value = '';
        }
      });
    });
  }
});
// Add this to your existing project.js file

// Handle donation amount button selection
document.addEventListener('DOMContentLoaded', function() {
  const amountButtons = document.querySelectorAll('.amount-btn');
  
  if (amountButtons.length > 0) {
    amountButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Remove active class from all buttons
        amountButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        this.classList.add('active');
        
        // Clear the custom amount input if it exists
        const customAmountInput = document.querySelector('.amount-input');
        if (customAmountInput) {
          customAmountInput.value = '';
        }
      });
    });
    
    // Handle custom amount input focus
    const customAmountInput = document.querySelector('.amount-input');
    if (customAmountInput) {
      customAmountInput.addEventListener('focus', function() {
        // Remove active class from all buttons when custom input is focused
        amountButtons.forEach(btn => btn.classList.remove('active'));
      });
    }
  }
});