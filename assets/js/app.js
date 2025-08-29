// Mobile nav
const burger = document.querySelector('#burger');
const nav = document.querySelector('#nav');
if (burger){
  burger.addEventListener('click',()=> nav.classList.toggle('open'));
}

function setupModal(triggerSel, modalSel){
  const t = document.querySelectorAll(triggerSel);
  const m = document.querySelector(modalSel);
  if(!m) return;
  const close = m.querySelector('[data-close]');
  t.forEach(el=> el.addEventListener('click', ()=> m.classList.add('open')));
  [m, close].forEach(el=> el && el.addEventListener('click', (e)=>{
    if(e.target===m || e.currentTarget===close){ m.classList.remove('open') }
  }));
}
setupModal('[data-open=callback]', '#modal-callback');
setupModal('[data-open=calculator]', '#modal-calculator');

// Calculator
const calcForm = document.querySelector('#calc-form');
if (calcForm){
  calcForm.addEventListener('input',()=>{
    const area = +calcForm.area.value || 0;
    const finish = +calcForm.finish.value || 0;
    const windows = +calcForm.windows.value || 0;
    const price = Math.round(area*45000 + finish*150000 + windows*25000);
    document.querySelector('#calc-result').textContent = price.toLocaleString('ru-RU') + ' ₽';
  });
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click', (e)=>{
    const id = a.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (el){
      e.preventDefault();
      el.scrollIntoView({behavior:'smooth', block:'start'});
      nav && nav.classList.remove('open');
    }
  })
});

// Project filter
const projectButtons = document.querySelectorAll('.projects-nav button');
const projectCards = document.querySelectorAll('.project-card');

if (projectButtons.length > 0) {
  projectButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.dataset.filter;
      
      // Update active button
      projectButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
      
      // Filter projects
      projectCards.forEach(card => {
        const category = card.dataset.category;
        if (filter === 'all' || category === filter) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
}

// AJAX Form submissions
document.addEventListener('DOMContentLoaded', function() {
  const forms = document.querySelectorAll('#contact-form, #callback-form');
  
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const submitButton = this.querySelector('.submit');
      const originalText = submitButton.textContent;
      
      // Show loading state
      submitButton.textContent = 'Отправляем...';
      submitButton.disabled = true;
      
      fetch(ajax_object.ajax_url, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Заявка отправлена! Мы свяжемся с вами.');
          this.reset();
          // Close modal if it's in modal
          const modal = this.closest('.modal');
          if (modal) {
            modal.classList.remove('open');
          }
        } else {
          alert('Произошла ошибка. Попробуйте еще раз.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка. Попробуйте еще раз.');
      })
      .finally(() => {
        submitButton.textContent = originalText;
        submitButton.disabled = false;
      });
    });
  });
});

// Initialize calculator on load
document.addEventListener('DOMContentLoaded', function() {
  const calcForm = document.querySelector('#calc-form');
  if (calcForm) {
    // Trigger calculation on load
    calcForm.dispatchEvent(new Event('input'));
  }
});