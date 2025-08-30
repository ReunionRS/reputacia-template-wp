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

const projectButtons = document.querySelectorAll('.projects-nav button');
const projectCards = document.querySelectorAll('.project-card');

if (projectButtons.length > 0) {
  projectButtons.forEach(button => {
    button.addEventListener('click', () => {
      const filter = button.dataset.filter;
      
      projectButtons.forEach(btn => btn.classList.remove('active'));
      button.classList.add('active');
      
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

class GallerySlider {
  constructor(slider) {
    this.slider = slider;
    this.track = slider.querySelector('.gallery-track');
    this.slides = slider.querySelectorAll('.gallery-slide');
    this.prevBtn = slider.querySelector('.gallery-prev');
    this.nextBtn = slider.querySelector('.gallery-next');
    this.dots = slider.querySelectorAll('.gallery-dot');
    
    this.currentSlide = 0;
    this.totalSlides = this.slides.length;
    
    this.init();
  }
  
  init() {
    if (this.totalSlides <= 1) return;
    
    if (this.prevBtn) {
      this.prevBtn.addEventListener('click', () => this.prevSlide());
    }
    
    if (this.nextBtn) {
      this.nextBtn.addEventListener('click', () => this.nextSlide());
    }
    
    this.dots.forEach((dot, index) => {
      dot.addEventListener('click', () => this.goToSlide(index));
    });
    
    let startX = 0;
    let currentX = 0;
    let isDragging = false;
    
    this.track.addEventListener('touchstart', (e) => {
      startX = e.touches[0].clientX;
      isDragging = true;
    });
    
    this.track.addEventListener('touchmove', (e) => {
      if (!isDragging) return;
      e.preventDefault();
      currentX = e.touches[0].clientX;
    });
    
    this.track.addEventListener('touchend', () => {
      if (!isDragging) return;
      isDragging = false;
      
      const diff = startX - currentX;
      const threshold = 50;
      
      if (diff > threshold) {
        this.nextSlide();
      } else if (diff < -threshold) {
        this.prevSlide();
      }
    });
    
    document.addEventListener('keydown', (e) => {
      if (!this.slider.matches(':hover')) return;
      
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        this.prevSlide();
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        this.nextSlide();
      }
    });
    
    this.autoPlay();
  }
  
  goToSlide(index) {
    this.currentSlide = index;
    this.updateSlider();
  }
  
  nextSlide() {
    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
    this.updateSlider();
  }
  
  prevSlide() {
    this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
    this.updateSlider();
  }
  
  updateSlider() {
    const translateX = -this.currentSlide * 100;
    this.track.style.transform = `translateX(${translateX}%)`;
    
    this.dots.forEach((dot, index) => {
      dot.classList.toggle('active', index === this.currentSlide);
    });
  }
  
  autoPlay() {
    if (this.totalSlides <= 1) return;
    
    setInterval(() => {
      if (!this.slider.matches(':hover')) {
        this.nextSlide();
      }
    }, 5000); 
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const gallerySliders = document.querySelectorAll('.gallery-slider');
  gallerySliders.forEach(slider => new GallerySlider(slider));
});

document.addEventListener('DOMContentLoaded', function() {
  const forms = document.querySelectorAll('#contact-form, #callback-form');
  
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const submitButton = this.querySelector('.submit');
      const originalText = submitButton.textContent;
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

document.addEventListener('DOMContentLoaded', function() {
  const calcForm = document.querySelector('#calc-form');
  if (calcForm) {
    calcForm.dispatchEvent(new Event('input'));
  }
});