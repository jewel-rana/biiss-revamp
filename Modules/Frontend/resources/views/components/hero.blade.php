<div>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container py-5">
            <div class="d-flex flex-column align-items-center gap-5">

                <!-- Logos Row -->
                <div class="d-flex justify-content-center align-items-end mb-0" style="height: 80px;">
                    <img src="/frontend/images/logo.png" alt="BIISS Logo" height="80" class="me-3">
                    <img src="/frontend/images/bd_logo.png" alt="Bangladesh Logo" height="80">
                </div>

                <!-- Search Bar Row -->
                <div class="mt-0 align-items-center search-field-container">

                    <div class="text-center text-white font-poppins" style="margin-bottom: 15px;">
                        <h4>Search in the library</h4>
                    </div>
                    <form method="GET" action="{{ route('front.search') }}">
                        <div class="d-flex flex-column flex-lg-row  align-items-center">
                            <!-- First Search -->
                            <div class="input-group flex-grow-1">
                                <input type="search" class="form-control search-input"
                                       placeholder="Search Book By Keyword or Title">
                            </div>

                            <!-- Second Search -->
                            <div class="input-group flex-grow-1 mt-lg-0 mt-2">
                                <input type="search" class="form-control search-input"
                                       placeholder="Search books by Author">
                                <div class="input-group-btn bg-white">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
