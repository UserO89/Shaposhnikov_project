document.addEventListener('DOMContentLoaded', function() {
    const accordionHeaders = document.querySelectorAll('.accordion-header');
  
    accordionHeaders.forEach(header => {
      header.addEventListener('click', function() {
        const parent = this.parentElement;
        const isActive = parent.classList.contains('active');
  
        accordionHeaders.forEach(h => h.parentElement.classList.remove('active'));
  
        if (!isActive) {
          parent.classList.add('active');
        }
      });
    });
  });
