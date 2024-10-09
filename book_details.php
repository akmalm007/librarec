<?php
include 'koneksi.php';
?>
<html>

<head>
    <title>Detail Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('navbar.php') ?>
    <div class="container">
        <div class="row">

            <h1>Halaman buku</h1>
            <?php
            $biblio_id = isset($_GET['biblio_id']) ? intval($_GET['biblio_id']) : 0;
            if ($biblio_id > 0) {
                $query = "SELECT * FROM buku WHERE biblio_id = $biblio_id";
                $result = mysqli_query($db, $query);
                if (mysqli_num_rows($result) > 0) {
                    $book = mysqli_fetch_assoc($result);
            ?>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1>Detail Buku</h1>
                                <div class="card mb-4">
                                    <img class="card-img-top" src="gambar/vector-modern-book-cover-design-template_1050343-242-removebg-preview.png" alt="Book cover">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $book['Judul']; ?></h5>
                                        <p class="card-text">
                                            <strong>Kategori:</strong> <?php echo $book['Kategori']; ?><br>
                                            <strong>Penulis:</strong> <?php echo $book['Penulis']; ?><br>
                                            <strong>Tahun:</strong> <?php echo $book['Tahun']; ?><br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <h3>Anggota lain juga membaca buku ini</h3>
                                <?php
                                $query_recommendation = "SELECT b.biblio_id, b.judul, b.kategori, b.penulis, b.tahun FROM model m 
                                LEFT JOIN buku b ON m.consequents_id = b.biblio_id  
                                WHERE m.antecedents_id IN (select biblio_id FROM buku WHERE biblio_id = $biblio_id) GROUP BY b.biblio_id";
                                $result_recommendation = mysqli_query($db, $query_recommendation);
                                if (mysqli_num_rows($result_recommendation) > 0) {
                                    while ($book_recommendation = mysqli_fetch_array($result_recommendation)) {
                                ?>
                                        <div class="card mb-3">
                                            <div class="row no-gutters">
                                                <div class="col-md-4">
                                                    <img src="gambar/book-covers-big-2019101610.jpg" class="card-img" alt="Related book">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $book_recommendation['judul'] ?></h5>
                                                        <p class="card-text">Penulis:<?php echo $book_recommendation['penulis']; ?> </p>
                                                        <p class="card-text">Tahun Terbit:<?php echo $book_recommendation['tahun']; ?> </p>
                                                        <p class="card-text">Kategori:<?php echo $book_recommendation['kategori']; ?> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } else {
                                    echo "not book founded";
                                } ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } ?>
        </div>
    </div>
</body>

</html>
