document.addEventListener('DOMContentLoaded', function() {
    
    const burger = document.querySelector('#burger');
    const nav = document.querySelector('#nav');
    if (burger && nav) {
        burger.addEventListener('click', () => {
            nav.classList.toggle('open');
        });
    }

    function setupModal(triggerSel, modalSel) {
        const triggers = document.querySelectorAll(triggerSel);
        const modal = document.querySelector(modalSel);
        if (!modal) return;
        
        const close = modal.querySelector('[data-close]');
        const dialog = modal.querySelector('.modal-dialog');
        
        triggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
                
                requestAnimationFrame(() => {
                    modal.style.opacity = '1';
                    if (dialog) {
                        dialog.style.transform = 'translateY(0) scale(1)';
                        dialog.style.opacity = '1';
                    }
                });
            });
        });

        function closeModal() {
            if (dialog) {
                dialog.style.transform = 'translateY(-30px) scale(0.95)';
                dialog.style.opacity = '0';
            }
            modal.style.opacity = '0';
            
            setTimeout(() => {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }, 300);
        }
        
        if (close) {
            close.addEventListener('click', closeModal);
        }
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        
        if (dialog) {
            dialog.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('open')) {
                closeModal();
            }
        });
    }
    
    setupModal('[data-open="callback"]', '#modal-callback');
    setupModal('[data-open="calculator"]', '#modal-calculator');

    class ProjectsCarousel {
        constructor(container) {
            this.container = container;
            this.track = container.querySelector('.projects-carousel-track');
            this.slides = container.querySelectorAll('.project-carousel-slide');
            this.prevBtn = container.querySelector('.carousel-prev');
            this.nextBtn = container.querySelector('.carousel-next');
            this.indicatorsContainer = container.querySelector('.projects-carousel-indicators');
            
            this.currentSlide = 0;
            this.totalSlides = this.slides.length;
            this.slidesPerView = this.getSlidesPerView();
            this.maxSlide = Math.max(0, this.totalSlides - this.slidesPerView);
            
            this.init();
            this.createIndicators();
            this.updateCarousel();
            
            window.addEventListener('resize', () => {
                this.slidesPerView = this.getSlidesPerView();
                this.maxSlide = Math.max(0, this.totalSlides - this.slidesPerView);
                this.currentSlide = Math.min(this.currentSlide, this.maxSlide);
                this.updateCarousel();
                this.createIndicators();
            });
        }
        
        getSlidesPerView() {
            if (window.innerWidth <= 768) return 1;
            if (window.innerWidth <= 1024) return 2;
            return 3;
        }
        
        init() {
            if (this.totalSlides <= this.slidesPerView) return;
            
            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', () => this.prevSlide());
            }
            
            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', () => this.nextSlide());
            }
            
            let startX = 0;
            let currentX = 0;
            let isDragging = false;
            
            this.track.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                isDragging = true;
                this.track.style.transition = 'none';
            });
            
            this.track.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                currentX = e.touches[0].clientX;
                const diff = startX - currentX;
                const slideWidth = this.slides[0].offsetWidth + 24; 
                const movePercent = (diff / slideWidth) * (100 / this.slidesPerView);
                const currentTransform = -(this.currentSlide * (100 / this.slidesPerView));
                this.track.style.transform = `translateX(${currentTransform - movePercent}%)`;
            });
            
            this.track.addEventListener('touchend', () => {
                if (!isDragging) return;
                isDragging = false;
                this.track.style.transition = '';
                
                const diff = startX - currentX;
                const threshold = 50;
                
                if (diff > threshold && this.currentSlide < this.maxSlide) {
                    this.nextSlide();
                } else if (diff < -threshold && this.currentSlide > 0) {
                    this.prevSlide();
                } else {
                    this.updateCarousel();
                }
            });
            
            document.addEventListener('keydown', (e) => {
                if (!this.container.matches(':hover')) return;
                
                if (e.key === 'ArrowLeft') {
                    e.preventDefault();
                    this.prevSlide();
                } else if (e.key === 'ArrowRight') {
                    e.preventDefault();
                    this.nextSlide();
                }
            });
        }
        
        createIndicators() {
            if (!this.indicatorsContainer) return;
            
            this.indicatorsContainer.innerHTML = '';
            const indicatorsCount = this.maxSlide + 1;
            
            if (indicatorsCount <= 1) return;
            
            for (let i = 0; i < indicatorsCount; i++) {
                const indicator = document.createElement('button');
                indicator.className = 'carousel-indicator';
                indicator.setAttribute('aria-label', `Перейти к слайду ${i + 1}`);
                indicator.addEventListener('click', () => this.goToSlide(i));
                this.indicatorsContainer.appendChild(indicator);
            }
        }
        
        goToSlide(index) {
            this.currentSlide = Math.max(0, Math.min(index, this.maxSlide));
            this.updateCarousel();
        }
        
        nextSlide() {
            if (this.currentSlide < this.maxSlide) {
                this.currentSlide++;
                this.updateCarousel();
            }
        }
        
        prevSlide() {
            if (this.currentSlide > 0) {
                this.currentSlide--;
                this.updateCarousel();
            }
        }
        
        updateCarousel() {
            const translateX = -(this.currentSlide * (100 / this.slidesPerView));
            this.track.style.transform = `translateX(${translateX}%)`;
            
            const indicators = this.indicatorsContainer?.querySelectorAll('.carousel-indicator');
            if (indicators) {
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === this.currentSlide);
                });
            }

            if (this.prevBtn) {
                this.prevBtn.disabled = this.currentSlide === 0;
                this.prevBtn.style.opacity = this.currentSlide === 0 ? '0.5' : '1';
            }
            
            if (this.nextBtn) {
                this.nextBtn.disabled = this.currentSlide >= this.maxSlide;
                this.nextBtn.style.opacity = this.currentSlide >= this.maxSlide ? '0.5' : '1';
            }
        }
    }

    const projectsCarouselContainer = document.querySelector('.projects-carousel-container');
    if (projectsCarouselContainer) {
        new ProjectsCarousel(projectsCarouselContainer);
    }

    const calcForm = document.querySelector('#calc-form');
    const areaInput = document.getElementById('area');
    const finishSelect = document.getElementById('finish');
    const windowsInput = document.getElementById('windows');
    const calcResult = document.getElementById('calc-result');
    const calculatedPriceInput = document.getElementById('calculated-price');
    
    function calculatePrice() {
        if (!areaInput || !finishSelect || !windowsInput || !calcResult) return;
        
        const area = parseInt(areaInput.value) || 0;
        const finish = finishSelect.value;
        const windows = parseInt(windowsInput.value) || 0;
        
        if (area < 10) {
            calcResult.textContent = '—';
            return;
        }
        
        let basePrice = area * 45000; 
        
        const finishMultipliers = {
            'Базовая': 0,
            'Комфорт': 150000,
            'Премиум': 300000
        };
        
        basePrice += finishMultipliers[finish] || 0;
        basePrice += windows * 25000; 
        
        const formattedPrice = basePrice.toLocaleString('ru-RU');
        calcResult.textContent = `от ${formattedPrice} ₽`;
        
        if (calculatedPriceInput) {
            calculatedPriceInput.value = `от ${formattedPrice} ₽`;
        }
    }
    
    if (calcForm) {
        calcForm.addEventListener('input', calculatePrice);
        calculatePrice();
    }

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
        const href = anchor.getAttribute('href');
        if (href === '#') return;
        
        const targetId = href.slice(1);
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
            e.preventDefault();
            
            const headerHeight = document.querySelector('.header').offsetHeight;
            const elementPosition = targetElement.offsetTop;
            const offsetPosition = elementPosition - headerHeight - 20; 
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            const nav = document.querySelector('#nav');
            if (nav && nav.classList.contains('open')) {
                nav.classList.remove('open');
            }
        }
    });
});

function updateActiveNavItem() {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('nav a[href^="#"]');
    
    let current = '';
    const headerHeight = document.querySelector('.header').offsetHeight;
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop - headerHeight - 100;
        const sectionHeight = section.offsetHeight;
        
        if (window.pageYOffset >= sectionTop && 
            window.pageYOffset < sectionTop + sectionHeight) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === `#${current}`) {
            link.classList.add('active');
        }
    });
}

window.addEventListener('scroll', updateActiveNavItem);
window.addEventListener('load', updateActiveNavItem);

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

const offerButtons = document.querySelectorAll('#offers .projects-nav button');
const offerCards = document.querySelectorAll('#offers .card');

if (offerButtons.length > 0) {
    offerButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            
            offerButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            offerCards.forEach(card => {
                const category = card.dataset.category;
                if (filter === 'all' || category === filter) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.5s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

    const gallerySliders = document.querySelectorAll('.gallery-slider');
    gallerySliders.forEach(slider => new GallerySlider(slider));

    const forms = document.querySelectorAll('#contact-form, #callback-form, #calc-form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('.submit');
            const originalText = submitButton.textContent;
            
            submitButton.textContent = 'Отправляем...';
            submitButton.disabled = true;
            submitButton.style.opacity = '0.7';
            
            fetch(ajax_object.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.data, 'success');
                    this.reset();
                    
                    const modal = this.closest('.modal');
                    if (modal) {
                        modal.querySelector('.close').click();
                    }
                    
                    if (this.id === 'calc-form') {
                        calculatePrice();
                    }
                } else {
                    showNotification(data.data || 'Произошла ошибка при отправке', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Произошла ошибка при отправке', 'error');
            })
            .finally(() => {
                submitButton.textContent = originalText;
                submitButton.disabled = false;
                submitButton.style.opacity = '1';
            });
        });
    });

    function showNotification(message, type = 'success') {
        const existingNotifications = document.querySelectorAll('.floating-notification');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = `floating-notification ${type === 'error' ? 'error' : ''}`;
        notification.innerHTML = `
            <div class="floating-notification-content">
                <div class="floating-notification-icon">
                    ${type === 'success' ? '✅' : '❌'}
                </div>
                <div>${message}</div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => notification.classList.add('show'), 100);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 400);
        }, 5000);
    }

    function animateOnScroll() {
        const elements = document.querySelectorAll('.card, .project-carousel-card, .review-card, .quick-info-card, .spec-card, .about-text, .technology-text');
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible && !element.classList.contains('animate')) {
                element.classList.add('animate', 'animate-fade-in-up');
            }
        });
    }

    setTimeout(() => {
        const heroTitle = document.querySelector('.hero-content h1');
        if (heroTitle) heroTitle.classList.add('animate-fade-in-up');
    }, 100);
    
    setTimeout(() => {
        const heroDesc = document.querySelector('.hero-content p');
        if (heroDesc) heroDesc.classList.add('animate-fade-in-up');
    }, 300);
    
    setTimeout(() => {
        const heroActions = document.querySelector('.hero-actions');
        if (heroActions) heroActions.classList.add('animate-fade-in-up');
    }, 500);
    
    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);

    const phoneInputs = document.querySelectorAll('input[name="phone"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.startsWith('8')) {
                value = '7' + value.substring(1);
            }
            
            if (value.startsWith('7')) {
                value = value.substring(0, 11);
                const formatted = value.replace(/(\d{1})(\d{3})(\d{3})(\d{2})(\d{2})/, '+$1 ($2) $3-$4-$5');
                e.target.value = formatted;
            }
        });
    });

    window.showNotification = showNotification;
    window.calculatePrice = calculatePrice;
});