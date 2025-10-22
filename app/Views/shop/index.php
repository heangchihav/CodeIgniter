<?= view('layout/header') ?>

<!-- Hero Carousel Section -->
<div class="relative overflow-hidden bg-gray-50">
    <?php if (!empty($banners)): ?>
    <div class="carousel relative">
        <!-- Carousel Items -->
        <?php foreach ($banners as $index => $banner): ?>
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>">
            <div class="relative h-[400px] sm:h-[500px] md:h-[600px] bg-gray-900">
                <img src="<?= base_url('uploads/banners/' . $banner['image']) ?>" 
                     alt="<?= esc($banner['title']) ?>" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>
                <div class="absolute inset-0 flex items-center">
                    <div class="max-w-7xl mx-auto px-12 sm:px-16 lg:px-8 w-full">
                        <div class="max-w-2xl">
                            <h1 class="text-2xl sm:text-3xl md:text-6xl font-bold mb-3 md:mb-4 text-white leading-tight animate-slideInLeft">
                                <?= esc($banner['title']) ?>
                            </h1>
                            <?php if ($banner['subtitle']): ?>
                            <p class="text-sm sm:text-base md:text-xl mb-4 md:mb-8 text-gray-200 animate-slideInLeft animation-delay-200">
                                <?= esc($banner['subtitle']) ?>
                            </p>
                            <?php endif; ?>
                            <?php if ($banner['button_text'] && $banner['button_link']): ?>
                            <a href="<?= base_url($banner['button_link']) ?>" 
                               class="inline-flex items-center gap-2 bg-white text-gray-900 px-5 py-2 sm:px-7 sm:py-3 rounded-lg text-sm sm:text-base font-semibold hover:bg-gray-100 transition-all duration-200 animate-slideInLeft animation-delay-400">
                                <?= esc($banner['button_text']) ?>
                                <i class="fas fa-arrow-right text-sm"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <!-- Navigation Arrows -->
        <?php if (count($banners) > 1): ?>
        <button onclick="prevSlide()" class="carousel-btn absolute left-2 sm:left-4 md:left-6 top-1/2 -translate-y-1/2 bg-white/95 hover:bg-white text-gray-800 p-2 sm:p-3 rounded-full transition-all duration-200 shadow-lg hover:shadow-xl active:scale-90 z-10">
            <i class="fas fa-chevron-left text-sm sm:text-lg"></i>
        </button>
        <button onclick="nextSlide(true)" class="carousel-btn absolute right-2 sm:right-4 md:right-6 top-1/2 -translate-y-1/2 bg-white/95 hover:bg-white text-gray-800 p-2 sm:p-3 rounded-full transition-all duration-200 shadow-lg hover:shadow-xl active:scale-90 z-10">
            <i class="fas fa-chevron-right text-sm sm:text-lg"></i>
        </button>

        <!-- Dots Indicator -->
        <div class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
            <?php foreach ($banners as $index => $banner): ?>
            <button onclick="goToSlide(<?= $index ?>)" 
                    class="carousel-dot h-1.5 transition-all duration-300 <?= $index === 0 ? 'w-8 bg-white' : 'w-1.5 bg-white/50' ?>" 
                    data-index="<?= $index ?>"></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <style>
    .carousel-item {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
        pointer-events: none;
    }
    .carousel-item.active {
        position: relative;
        opacity: 1;
        pointer-events: auto;
    }
    
    @keyframes slideInLeft {
        from { 
            opacity: 0; 
            transform: translateX(-30px);
        }
        to { 
            opacity: 1; 
            transform: translateX(0);
        }
    }
    
    .animate-slideInLeft {
        animation: slideInLeft 0.6s ease-out forwards;
        opacity: 0;
    }
    
    .animation-delay-200 {
        animation-delay: 0.15s;
    }
    
    .animation-delay-400 {
        animation-delay: 0.3s;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in-up {
        animation: fadeInUp 0.5s ease-out forwards;
    }
    </style>

    <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-item');
    const dots = document.querySelectorAll('.carousel-dot');
    const totalSlides = slides.length;
    let autoPlayInterval = null;
    let isUserInteracting = false;

    function showSlide(index) {
        slides[currentSlide].style.opacity = '0';
        
        setTimeout(() => {
            slides.forEach(slide => {
                slide.classList.remove('active');
                slide.style.position = 'absolute';
            });
            
            slides[index].classList.add('active');
            slides[index].style.position = 'relative';
            slides[index].style.opacity = '1';
            
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.remove('w-1.5', 'bg-white/50');
                    dot.classList.add('w-8', 'bg-white');
                } else {
                    dot.classList.remove('w-8', 'bg-white');
                    dot.classList.add('w-1.5', 'bg-white/50');
                }
            });
            
            currentSlide = index;
        }, 50);
    }

    function nextSlide(isManual = false) {
        if (isManual) {
            pauseAutoPlay();
        }
        const next = (currentSlide + 1) % totalSlides;
        showSlide(next);
    }

    function prevSlide() {
        pauseAutoPlay();
        const prev = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(prev);
    }

    function goToSlide(index) {
        pauseAutoPlay();
        showSlide(index);
    }

    function pauseAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
            isUserInteracting = true;
            
            setTimeout(() => {
                if (isUserInteracting) {
                    startAutoPlay();
                    isUserInteracting = false;
                }
            }, 10000);
        }
    }

    function startAutoPlay() {
        <?php if (count($banners) > 1): ?>
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
        autoPlayInterval = setInterval(() => nextSlide(false), 5000);
        <?php endif; ?>
    }

    startAutoPlay();
    
    // Intersection Observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.observe-fade').forEach(el => observer.observe(el));
    });
    </script>
    <?php else: ?>
    <!-- Default Hero if no banners -->
    <div class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="max-w-3xl">
                <h1 class="text-2xl sm:text-4xl md:text-6xl font-bold mb-3 md:mb-4 leading-tight">Welcome to E-Shop</h1>
                <p class="text-sm sm:text-lg md:text-xl mb-4 md:mb-8 text-gray-300">Discover amazing products at unbeatable prices</p>
                <a href="<?= base_url('/products') ?>" class="inline-flex items-center gap-2 bg-white text-gray-900 px-5 py-2 sm:px-7 sm:py-3 text-sm sm:text-base font-semibold hover:bg-gray-100 transition-all duration-200">
                    Shop Now
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Main Content with Sidebar -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar - Categories -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="bg-white shadow-sm border border-gray-200 sticky top-4">
                <div class="border-b border-gray-200 p-5">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-th-large mr-2 text-gray-600"></i>
                        Categories
                    </h2>
                </div>
                <nav class="p-3">
                    <a href="<?= base_url('/products') ?>" 
                       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors duration-150 border-l-2 border-transparent hover:border-gray-900">
                        <i class="fas fa-th-large mr-3 text-gray-500"></i>
                        <span class="font-medium">All Products</span>
                    </a>
                    <?php foreach ($categories as $category): ?>
                    <a href="<?= base_url('/products?category=' . $category['id']) ?>" 
                       class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors duration-150 border-l-2 border-transparent hover:border-gray-900">
                        <i class="fas fa-tag mr-3 text-gray-500"></i>
                        <span class="font-medium"><?= esc($category['name']) ?></span>
                    </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            
            <!-- Flash Deals / Discounted Products -->
            <?php if (!empty($discountedProducts)): ?>
            <section class="mb-12 observe-fade opacity-0">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2 mb-1">
                            <i class="fas fa-bolt text-red-600"></i>
                            Flash Deals
                        </h2>
                        <p class="text-sm text-gray-600">Limited time offers</p>
                    </div>
                    <a href="<?= base_url('/products/deals') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-700 flex items-center gap-1">
                        View All 
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <?php foreach ($discountedProducts as $product): ?>
                        <?= view('components/product_card', ['product' => $product, 'badgeType' => 'discount']) ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- New Arrivals -->
            <?php if (!empty($newProducts)): ?>
            <section class="mb-12 observe-fade opacity-0">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2 mb-1">
                            <i class="fas fa-sparkles text-green-600"></i>
                            New Arrivals
                        </h2>
                        <p class="text-sm text-gray-600">Latest products</p>
                    </div>
                    <a href="<?= base_url('/products/new') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-700 flex items-center gap-1">
                        View All 
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <?php foreach ($newProducts as $product): ?>
                        <?= view('components/product_card', ['product' => $product, 'badgeType' => 'new']) ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Popular Products -->
            <?php if (!empty($popularProducts)): ?>
            <section class="mb-12 observe-fade opacity-0">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2 mb-1">
                            <i class="fas fa-fire text-orange-600"></i>
                            Popular Products
                        </h2>
                        <p class="text-sm text-gray-600">Trending items</p>
                    </div>
                    <a href="<?= base_url('/products/popular') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-700 flex items-center gap-1">
                        View All 
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <?php foreach ($popularProducts as $product): ?>
                        <?= view('components/product_card', ['product' => $product, 'badgeType' => 'popular']) ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

            <!-- Featured Products -->
            <?php if (!empty($featuredProducts)): ?>
            <section class="mb-12 observe-fade opacity-0">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-2 mb-1">
                            <i class="fas fa-star text-blue-600"></i>
                            Featured Products
                        </h2>
                        <p class="text-sm text-gray-600">Handpicked selection</p>
                    </div>
                    <a href="<?= base_url('/products/featured') ?>" class="text-sm font-medium text-gray-900 hover:text-gray-700 flex items-center gap-1">
                        View All 
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <?php foreach ($featuredProducts as $product): ?>
                        <?= view('components/product_card', ['product' => $product, 'badgeType' => 'featured']) ?>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

        </main>
        
    </div>

    <!-- All Products Section -->
    <section class="mt-16 mb-12 observe-fade opacity-0">
        <div class="bg-gray-900 shadow-sm p-8 mb-8 border border-gray-800">
            <div class="text-center text-white">
                <h2 class="text-2xl font-bold mb-2 flex items-center justify-center gap-2">
                    <i class="fas fa-shopping-bag"></i>
                    All Products
                </h2>
                <p class="text-gray-300">Explore our complete collection - <?= !empty($allProducts) ? count($allProducts) : 0 ?> products available</p>
            </div>
        </div>

        <?php if (!empty($allProducts)): ?>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($allProducts as $product): ?>
                <?= view('components/product_card', ['product' => $product, 'badgeType' => 'none']) ?>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-16 bg-white shadow-sm border border-gray-200">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 mb-4">
                <i class="fas fa-box-open text-4xl text-gray-400"></i>
            </div>
            <p class="text-gray-600 text-lg font-medium">No products available at the moment</p>
            <p class="text-gray-500 text-sm mt-1">Check back soon for new items</p>
        </div>
        <?php endif; ?>
    
</div>

<?= view('layout/footer') ?>