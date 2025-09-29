document.addEventListener('DOMContentLoaded', function() {
    // Toggle between individual and team
    const individualBtn = document.getElementById('individual-btn');
    const teamBtn = document.getElementById('team-btn');
    
    individualBtn.addEventListener('click', function() {
        individualBtn.classList.add('active');
        teamBtn.classList.remove('active');
    });
    
    teamBtn.addEventListener('click', function() {
        teamBtn.classList.add('active');
        individualBtn.classList.remove('active');
    });
    
    // File upload handling
    const fileInput = document.getElementById('file');
    const fileText = document.querySelector('.file-text');
    
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            fileText.textContent = fileInput.files[0].name;
            
            // Check file size (max 2MB)
            const fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
            if (fileSize > 2) {
                alert('حجم الملف كبير جدًا. الحد الأقصى هو 2 ميجابايت.');
                fileInput.value = '';
                fileText.textContent = 'اختر ملف';
            }
        } else {
            fileText.textContent = 'اختر ملف';
        }
    });
    
    // Form submission
    const loginForm = document.getElementById('login-form');
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const name = document.getElementById('name').value;
        const identity = document.getElementById('identity').value;
        const mobile = document.getElementById('mobile').value;
        const activity = document.getElementById('activity').value;
        
        // Basic validation
        if (!name || !identity || !mobile || !activity) {
            alert('يرجى ملء جميع الحقول المطلوبة');
            return;
        }
        
        // Here you would typically send the data to your server
        console.log('Form submitted:', {
            name,
            identity,
            mobile,
            activity,
            type: individualBtn.classList.contains('active') ? 'individual' : 'team'
        });
        
        // For demo purposes, show success message
        alert('تم إرسال البيانات بنجاح!');
        loginForm.reset();
        fileText.textContent = 'اختر ملف';
    });
});