// Mobile Menu Toggle
 const mobileMenuBtn = document.getElementById('mobileMenuBtn');
 const navLinks = document.getElementById('navLinks');
 const dropdowns = document.querySelectorAll('.dropdown');

 mobileMenuBtn.addEventListener('click', () => {
     navLinks.classList.toggle('active');
     mobileMenuBtn.innerHTML = navLinks.classList.contains('active') ? 
         '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
 });

 dropdowns.forEach(dropdown => {
     const link = dropdown.querySelector('a');
     
     link.addEventListener('click', (e) => {
         if (window.innerWidth <= 992) {
             e.preventDefault();
             dropdown.classList.toggle('active');
         }
     });
 });

 // Modal Toggles
 const loginIcon = document.getElementById('loginIcon');
 const loginModal = document.getElementById('loginModal');
 const closeLoginModal = document.getElementById('closeLoginModal');
 const cancelLogin = document.getElementById('cancelLogin');
 const registerLink = document.createElement('p');
 registerLink.innerHTML = 'Nuk keni llogari? <a href="#" id="showRegisterModal">Regjistrohu tani</a>';
 registerLink.style.marginTop = '1rem';
 registerLink.style.textAlign = 'center';
 document.querySelector('#loginForm').after(registerLink);

 const registerModal = document.getElementById('registerModal');
 const showRegisterModal = document.getElementById('showRegisterModal');
 const closeRegisterModal = document.getElementById('closeRegisterModal');
 const cancelRegister = document.getElementById('cancelRegister');

 const overlay = document.getElementById('overlay');

 function toggleModal(modal) {
     modal.classList.toggle('active');
     overlay.classList.toggle('active');
     document.body.style.overflow = modal.classList.contains('active') ? 'hidden' : '';
 }

 loginIcon.addEventListener('click', () => toggleModal(loginModal));
 closeLoginModal.addEventListener('click', () => toggleModal(loginModal));
 cancelLogin.addEventListener('click', () => toggleModal(loginModal));
 overlay.addEventListener('click', () => {
     toggleModal(loginModal);
     toggleModal(registerModal);
 });

 showRegisterModal.addEventListener('click', (e) => {
     e.preventDefault();
     toggleModal(loginModal);
     toggleModal(registerModal);
 });

 closeRegisterModal.addEventListener('click', () => toggleModal(registerModal));
 cancelRegister.addEventListener('click', () => toggleModal(registerModal));

 // Cart Toggle
 const cartIcon = document.getElementById('cartIcon');
 const cartSidebar = document.getElementById('cartSidebar');
 const closeCart = document.getElementById('closeCart');

 cartIcon.addEventListener('click', () => {
     cartSidebar.classList.add('active');
     overlay.classList.add('active');
     document.body.style.overflow = 'hidden';
 });

 closeCart.addEventListener('click', () => {
     cartSidebar.classList.remove('active');
     overlay.classList.remove('active');
     document.body.style.overflow = '';
 });

 overlay.addEventListener('click', () => {
     cartSidebar.classList.remove('active');
     overlay.classList.remove('active');
     document.body.style.overflow = '';
 });

 // Filter Books
 const filterTags = document.querySelectorAll('.filter-tag');
 const bookCards = document.querySelectorAll('.book-card');

 filterTags.forEach(tag => {
     tag.addEventListener('click', () => {
         const filterValue = tag.textContent.trim();
         
         filterTags.forEach(t => t.classList.remove('active'));
         tag.classList.add('active');

         bookCards.forEach(card => {
             const categories = card.dataset.cat
             egory.split(' ');
             
             if (filterValue === 'Të gjitha' || categories.includes(filterValue.toLowerCase().replace(' ', '-'))) {
                 card.style.display = 'block';
             } else {
                 card.style.display = 'none';
             }
         });
     });
 });

 // Add to Cart
 const addToCartBtns = document.querySelectorAll('.add-to-cart');
 const cartBadge = document.querySelector('.cart-icon .badge');
 let cartItemsCount = parseInt(cartBadge.textContent);

 addToCartBtns.forEach(btn => {
     btn.addEventListener('click', function() {
         // Change button text temporarily
         const originalText = this.innerHTML;
         this.innerHTML = '<i class="fas fa-check"></i> Shtuar';
         this.style.backgroundColor = 'var(--success)';
         
         // Increment cart count
         cartItemsCount++;
         cartBadge.textContent = cartItemsCount;
         
         // Reset button after 2 seconds
         setTimeout(() => {
             this.innerHTML = originalText;
             this.style.backgroundColor = 'var(--secondary)';
         }, 2000);
     });
 });

 // Animations on scroll
 const animateElements = document.querySelectorAll('.animate');
 
 function checkAnimation() {
     animateElements.forEach(element => {
         const elementPosition = element.getBoundingClientRect().top;
         const screenPosition = window.innerHeight / 1.2;
         
         if (elementPosition < screenPosition) {
             element.style.opacity = '1';
         }
     });
 }

 window.addEventListener('scroll', checkAnimation);
 window.addEventListener('load', checkAnimation);
