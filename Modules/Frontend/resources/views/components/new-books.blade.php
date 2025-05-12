<div>
    <!-- New Books Section -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title">New Books</h2>
                <a href="#" class="view-all">View all</a>
            </div>
            <div class="row g-3">
                <div class="col-12 position-relative">
                    <div class="owl-carousel owl-new-book">
                        @foreach($books as $book)
                            <x-frontend::carousel-item :book="$book"></x-frontend::carousel-item>
                        @endforeach
                    </div>

                    <!-- Left Arrow -->
                    <button class="slider-arrow slider-arrow-new-book prev d-none d-md-inline"
                            aria-label="Previous">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" fill="none"
                             stroke="currentColor"
                             stroke-width="2.5" viewBox="0 0 16 16">
                            <path d="M10.5 2L5 8l5.5 6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <!-- Right Arrow -->
                    <button class="slider-arrow slider-arrow-new-book next d-none d-md-inline" aria-label="Next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" fill="none"
                             stroke="currentColor"
                             stroke-width="2.5" viewBox="0 0 16 16">
                            <path d="M5.5 2L11 8l-5.5 6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                </div>
            </div>
        </div>
    </section>
</div>
