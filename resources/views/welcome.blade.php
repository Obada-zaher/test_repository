@extends('layouts.app')

@section('content')
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container">
            <a class="navbar-brand" href="#">Newsify</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Discover</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-2" href="/register">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold">Welcome to Newsify!</h1>
                    <p class="mt-4">Discover what is happening now, meet the best news publishers, interact and make new friends.</p>
                    <a href="/shop" class="btn btn-light btn-lg me-2">Discover Now</a>
                    <a href="#services" class="btn btn-outline-light btn-lg">Learn More</a>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('images/home.svg') }}" alt="Hero Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <section id="services" class="services-section py-5">
        <div class="container text-center">
            <h2 class="fw-bold">Our Services</h2>
            <p class="text-muted">We offer a wide range of news published by our users.</p>
            <div class="row mt-4">
                <div class="col-md-4">
                    <h5>Free Experience</h5>
                    <p>Enjoy exploring our site for free!</p>
                </div>
                <div class="col-md-4">
                    <h5>24/7 Support</h5>
                    <p>Our support team is available 24/7 to assist you.</p>
                </div>
                <div class="col-md-4">
                    <h5>Secure Opportunities</h5>
                    <p>We ensure your safety.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4">
        <div class="container">
            <p>&copy; 2025 Newsify. All Rights Reserved.</p>
            <p>
                Follow us:
                <a href="#">Facebook</a> |
                <a href="#">Twitter</a> |
                <a href="#">Instagram</a>
            </p>
        </div>
    </footer>

  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
</body>
</html>
@endsection
