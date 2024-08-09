<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientia Square Park</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <!-- Header: Termasuk Navbar -->
    <?php include('includes/header.php'); ?>

    <main>
        <!-- Section 1: Foto Slide -->
        <section id="hero" class="mb-4">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/img/slide1.jpeg" class="d-block w-100" alt="Slide 1">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/img/slide2.jpeg" class="d-block w-100" alt="Slide 2">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/img/slide3.jpeg" class="d-block w-100" alt="Slide 3">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </section>

        <!-- Section 2: Scientia Square Park -->
        <section id="welcome" class="text-center mb-4">
            <div class="container">
                <h1>Scientia Square Park</h1>
            </div>
        </section>

        <!-- Section 3: About -->
        <section id="about" class="mb-4">
            <div class="container">
                <p class="text-center">
                Scientia Square Park adalah destinasi wisata yang sempurna untuk keluarga dan teman-teman yang ingin menikmati berbagai aktivitas outdoor menarik. Terletak strategis di tengah kota, taman ini menawarkan suasana alami dengan pemandangan hijau yang menyejukkan, menjadikannya tempat yang ideal untuk bersantai dan beraktivitas di luar ruangan.
                </p>
            </div>
        </section>

        <!-- Section 4: Card Google Maps & Video -->
        <section id="info" class="mb-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-center">Lokasi</h5>
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0507744136085!2d106.61292547499062!3d-6.257041993731495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fc651e649223%3A0x3b96f2ef67285cd9!2sScientia%20Square%20Park!5e0!3m2!1sid!2sid!4v1722856884931!5m2!1sid!2sid"
                                        width="100%" height="300" style="border:0;" allowfullscreen="" 
                                        loading="lazy" referrerpolicy="no-referrer-when-cross-origin">
                                </iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-center">Video Tour</h5>
                                <iframe width="100%" height="300" src="https://www.youtube.com/embed/xbqah8LUP9U?si=5kX96OWsampMZjnb" title="YouTube video player"
                                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 5: Galeri -->
        <section id="gallery" class="text-center mb-4">
            <div class="container">
                <h3 class="text-center"><strong>Galeri</strong></h3><br>
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal1.jpg" class="img-fluid" alt="Galeri 1">
                            <div class="overlay">
                                <span>Berkuda</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal2.jpg" class="img-fluid" alt="Galeri 2">
                            <div class="overlay">
                                <span>Memberi makan kelinci</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal3.jpg" class="img-fluid" alt="Galeri 3">
                            <div class="overlay">
                                <span>Bermain di kolam ikan</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal4.jpg" class="img-fluid" alt="Galeri 4">
                            <div class="overlay">
                                <span>Melihat kerbau</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal5.jpg" class="img-fluid" alt="Galeri 5">
                            <div class="overlay">
                                <span>Bermain sepatu roda</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal6.jpg" class="img-fluid" alt="Galeri 6">
                            <div class="overlay">
                                <span>Bermain skateboard</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal7.jpg" class="img-fluid" alt="Galeri 7">
                            <div class="overlay">
                                <span>Bermain panjat tebing</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal8.jpg" class="img-fluid" alt="Galeri 8">
                            <div class="overlay">
                                <span>Berenang</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal9.jpg" class="img-fluid" alt="Galeri 9">
                            <div class="overlay">
                                <span>Memancing ikan</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal10.jpg" class="img-fluid" alt="Galeri 10">
                            <div class="overlay">
                                <span>Outbound</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal11.jpg" class="img-fluid" alt="Galeri 11">
                            <div class="overlay">
                                <span>Burung hantu</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="position-relative">
                            <img src="assets/img/gal12.jpg" class="img-fluid" alt="Galeri 12">
                            <div class="overlay">
                                <span>Kura-kura</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
