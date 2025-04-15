<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Platform untuk mengelola prestasi dan rekognisi mahasiswa." />
    <meta name="author" content="" />
    <title>Prestasi & Rekognisi Mahasiswa</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.ico') ?>" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="..." crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Local CSS -->
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" />

</head>

<body>
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="#">Prestasi & Rekognisi</a>
            <a class="btn btn-primary" href="auth">Login</a>
        </div>
    </nav>

    <header class="masthead" style="background-image: url('<?= base_url('assets/img/hero3.webp') ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <h1 class="mb-5">Prestasi Gemilang, Masa Depan Cemerlang!</h1>
                        <p class="lead">Platform untuk mendokumentasikan dan mengelola prestasi mahasiswa akademik dan non-akademik Prodi Sistem Informasi</p>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi-award m-auto text-primary"></i></div>
                        <h3>Pendataan Prestasi</h3>
                        <p class="lead mb-0">Dokumentasikan setiap prestasi mahasiswa dengan mudah dan terstruktur.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi-check2-square m-auto text-primary"></i></div>
                        <h3>Verifikasi Otomatis</h3>
                        <p class="lead mb-0">Memastikan keabsahan data melalui proses verifikasi oleh prodi.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex"><i class="bi bi-bar-chart-line m-auto text-primary"></i></div>
                        <h3>Analisis & Laporan</h3>
                        <p class="lead mb-0">Memonitor pencapaian mahasiswa dalam bentuk laporan dan statistik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row g-0 bg-light">
                <div class="col-lg-6 order-lg-2 showcase-img" style="background-image: url('<?= base_url('assets/img/platform.png') ?>');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Platform Terintegrasi</h2>
                    <p class="lead mb-0">Seluruh data prestasi mahasiswa terhubung dengan sistem akademik universitas.</p>
                </div>
            </div>
            <div class="row g-0 bg-light">
                <div class="col-lg-6 showcase-img" style="background-image: url('<?= base_url('assets/img/validasi.png') ?>');"></div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2>Validasi Prestasi & Rekognisi</h2>
                    <p class="lead mb-0">Prestasi mahasiswa yang telah tervalidasi akan terdokumentasi dan berkontribusi pada rekam jejak akademik mereka.</p>
                </div>
            </div>
            <div class="row g-0 bg-light">
                <div class="col-lg-6 order-lg-2 showcase-img" style="background-image: url('<?= base_url('assets/img/analisis.png') ?>');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Analisis Perkembangan</h2>
                    <p class="lead mb-0">Pantau perkembangan prestasi mahasiswa melalui dashboard interaktif.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-light p-4">
        <div class="text-center mx-0">
            <p class="text-muted small mb-0">&copy; 2025 Prestasi & Rekognisi Mahasiswa 2025.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="..." crossorigin="anonymous"></script>

    <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
</body>

</html>