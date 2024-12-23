<?php
include 'koneksi.php';
?>
<!doctype html>
<html>

<head>
    <title>Librec: Library Recommendation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'navbar.php' ?>

    <section id="home" class="hero-area bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Hero Text -->
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="hero-content">
                        <h1 class="fw-bold wow fadeInLeft" data-wow-delay=".4s">Library Recommendation</h1>
                        <p class="wow fadeInLeft" data-wow-delay=".6s">Tempat yang tepat untuk mencari buku favorit anda</p>
                        <a href="#koleksi" class="btn btn-light btn-lg mt-3">Lihat Koleksi Buku</a>
                    </div>
                </div>
                <!-- Hero Image -->
                <div class="col-lg-7 col-md-12 col-12 text-center">
                    <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                        <img src="./gambar/library-recommendation-high-resolution-logo-removebg-preview.png"
                            alt="Library Recommendation Logo"
                            class="img-fluid rounded shadow-lg"
                            style="max-height: 400px; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="koleksi">
        <div class="container mt-5 mb-5 text-center">
            <!-- Centered Heading -->
            <h3 class="fw-bold">Koleksi Buku</h3>
        </div>
    </section>

    <div class="container mt-5">
        <div class="card p-4 shadow">
            <form class="row g-3 align-items-center" action="#koleksi" role="search" method="get">
                <!-- Search Input -->
                <div class="col-md-6">
                    <div class="input-group">
                        <input
                            name="pencarian"
                            type="search"
                            class="form-control"
                            placeholder="Cari Judul Buku, atau Kategori Buku"
                            aria-label="Search"
                            value="<?php echo isset($_GET['pencarian']) ? htmlspecialchars($_GET['pencarian']) : ''; ?>">
                        <button class="btn btn-primary" style="width: 150px; height: 40px;" type="submit">Cari</button>
                    </div>
                </div>

                <!-- Dropdowns and Filter -->
                <div class="col-md-6">
                    <div class="input-group">
                        <!-- Dropdown for Category -->
                        <select name="kategori" class="form-select" style="width: 150px; height: 40px;">
                            <option value="">Semua Kategori</option>
                            <?php
                            $q_kategori = "SELECT DISTINCT kategori FROM buku";
                            $result_kategori = mysqli_query($db, $q_kategori);
                            while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                                $selected = isset($_GET['kategori']) && $_GET['kategori'] == $row_kategori['kategori'] ? 'selected' : '';
                                echo "<option value='{$row_kategori['kategori']}' $selected>{$row_kategori['kategori']}</option>";
                            }
                            ?>
                        </select>

                        <!-- Dropdown for Year -->
                        <select name="tahun" class="form-select" style="width: 150px; height: 40px;">
                            <option value="">Semua Tahun</option>
                            <?php
                            $q_tahun = "SELECT DISTINCT tahun FROM buku ORDER BY tahun DESC";
                            $result_tahun = mysqli_query($db, $q_tahun);
                            while ($row_tahun = mysqli_fetch_assoc($result_tahun)) {
                                $selected = isset($_GET['tahun']) && $_GET['tahun'] == $row_tahun['tahun'] ? 'selected' : '';
                                echo "<option value='{$row_tahun['tahun']}' $selected>{$row_tahun['tahun']}</option>";
                            }
                            ?>
                        </select>

                        <!-- Filter Button -->
                        <button class="btn btn-primary" style="width: 100px; height: 40px;" type="submit">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <?php
            // Check if 'pencarian' is set and not empty
            $pencarian = isset($_GET['pencarian']) ? trim(mysqli_real_escape_string($db, $_GET['pencarian'])) : '';
            $kategori = isset($_GET['kategori']) ? trim(mysqli_real_escape_string($db, $_GET['kategori'])) : '';
            $tahun = isset($_GET['tahun']) ? trim(mysqli_real_escape_string($db, $_GET['tahun'])) : '';

            $query_koleksi = "SELECT judul, penulis, tahun, kategori FROM buku WHERE 1=1";

            if ($pencarian != '') {
                $query_koleksi .= " AND (judul LIKE '%$pencarian%' OR kategori LIKE '%$pencarian%')";
            }

            if ($kategori != '') {
                $query_koleksi .= " AND kategori = '$kategori'";
            }

            if ($tahun != '') {
                $query_koleksi .= " AND tahun = '$tahun'";
            }

            $query_koleksi .= " LIMIT 9";

            $q_tampil_koleksi = mysqli_query($db, $query_koleksi);

            if (mysqli_num_rows($q_tampil_koleksi) > 0) {
                while ($r_query_koleksi = mysqli_fetch_array($q_tampil_koleksi)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $r_query_koleksi['judul'] ?></h5>
                                <p class="card-text"><strong>Kategori: </strong> <?php echo $r_query_koleksi['kategori'] ?></p>
                                <p class="card-text"><strong>Penulis: </strong> <?php echo $r_query_koleksi['penulis'] ?></p>
                                <p class="card-text"><strong>Tahun: </strong><?php echo $r_query_koleksi['tahun'] ?></p>
                            </div>
                            <img src="gambar/vector-modern-book-cover-design-template_1050343-242-removebg-preview.png" class="card-img-top" alt="" style="height: 300px; object-fit: cover;">
                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="col-12">
                    <h3 class="text-center">Tidak ada hasil untuk pencarian "<span class="text-primary"><?php echo htmlspecialchars($pencarian); ?></span>"</h3>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

</body>


</html>
