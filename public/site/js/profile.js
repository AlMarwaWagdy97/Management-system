document.addEventListener('DOMContentLoaded', function() {
  // Tab switching functionality
  const tabs = document.querySelectorAll('.sidebar-item');
  const contents = document.querySelectorAll('.profile-content');

  
  tabs.forEach(tab => {
      document.getElementById('personal-info-content').style.display = 'block';
    tab.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Remove active class from all tabs
      tabs.forEach(t => t.classList.remove('active'));
      
      // Add active class to clicked tab
      this.classList.add('active');
      
      // Hide all content sections
      contents.forEach(content => {
        content.style.display = 'none';
      });
      
      // Show corresponding content
      const targetId = this.id.replace('-tab', '-content');
      document.getElementById(targetId).style.display = 'block';
    });
  });
  
  // Filter buttons functionality
  const filterButtons = document.querySelectorAll('.filter-btn');
  
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Remove active class from all filter buttons
      filterButtons.forEach(btn => btn.classList.remove('active'));
      
      // Add active class to clicked button
      this.classList.add('active');
      
      // Filter logic would go here
      // For now, we're just toggling the active state
    });
  });
});