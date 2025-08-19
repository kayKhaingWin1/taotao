<?php include_once __DIR__ . "/layout/header.php"; ?>

<div class="container-fluid">
    <section class="video-banner position-relative">
        <video id="videoPlayer" autoplay muted playsinline class="w-100" style="height: 80vh; object-fit: cover;"></video>


        <div class="banner-text position-absolute text-white text-center w-100">
            <h1 class="fw-bold display-4">Welcome to Taotao</h1>
            <p class="lead">Reliable. Elegant. Efficient.</p>
        </div>


        <div class="video-controls glass-effect position-absolute px-3 py-2 rounded-3"
            style="bottom: 3%; left: 50%; transform: translateX(-50%); z-index: 3;">
            <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                <button id="prevBtn" class="btn btn-outline-light btn-sm">⏮</button>
                <button id="playPauseBtn" class="btn btn-outline-light btn-sm">⏸</button>
                <button id="nextBtn" class="btn btn-outline-light btn-sm">⏭</button>
            </div>

            <div class="d-flex gap-2 justify-content-center align-items-center video-progress-container">
                <div class="video-progress-line" data-index="0"></div>
                <div class="video-progress-line" data-index="1"></div>
                <div class="video-progress-line" data-index="2"></div>
                <div class="video-progress-line" data-index="3"></div>
            </div>

        </div>


    </section>


    <section class="fashion-grid py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="image-box fade-in-up">
                        <img src="img/img1.jpg" alt="Look 1" class="img-fluid grid-img">
                        <div class="overlay-text">
                            <h3>Elegant Essentials</h3>
                            <p>Curated looks for everyday sophistication</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="image-box fade-in-up delay-1">
                        <img src="img/img2.jpg" alt="Look 2" class="img-fluid grid-img">
                        <div class="overlay-text">
                            <h3>Monochrome Muse</h3>
                            <p>Bold black and white fashion statements</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="image-box fade-in-up delay-2">
                        <img src="img/img4.jpg" alt="Look 3" class="img-fluid grid-img">
                        <div class="overlay-text">
                            <h4>Street Luxe</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="image-box fade-in-up delay-3">
                        <img src="img/img3.jpg" alt="Look 4" class="img-fluid grid-img">
                        <div class="overlay-text">
                            <h4>Modern Muse</h4>
                            <p>Where minimal meets chic</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="image-box fade-in-up delay-4">
                        <img src="img/img5.jpg" alt="Look 5" class="img-fluid grid-img">
                        <div class="overlay-text">
                            <h4>Refined Comfort</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="image-box fade-in-up delay-5">
                        <img src="img/img6.jpg" alt="Look 6" class="img-fluid grid-img">
                        <div class="overlay-text">
                            <h4>Power Silhouettes</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="new-in-section">
        <div class="container-fluid p-0">
            <h4 class="text-center text-uppercase fw-bold py-4">New In</h4>
            <div class="row g-0">
                <?php
                for ($i = 0; $i < 12; $i++):
                ?>
                    <div class="col-6 col-md-2">
                        <img src="img/dress.jpg" alt="New In <?= $i + 1 ?>" class="img-fluid new-img" />
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <section class="brand-carousel mt-5">
        <div class="carousel-wrapper">
            <h4 class="text-center text-uppercase fw-bold py-4">Brands</h4>
            <div class="carousel-track">
                <?php for ($i = 0; $i < 9; $i++): ?>
                    <div class="brand-item">
                        <img src="img/dress.jpg" alt="Brand <?= $i + 1 ?>" />
                    </div>
                <?php endfor; ?>


                <?php for ($i = 0; $i < 9; $i++): ?>
                    <div class="brand-item">
                        <img src="img/img1.jpg" alt="Brand <?= $i + 1 ?>" />
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>


</div>



<?php include_once __DIR__ . "/layout/footer.php"; ?>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });
    });
</script>