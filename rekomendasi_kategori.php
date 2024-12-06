<?php
include('koneksi.php');
?>
<html>

<head>
    <title>Librec: Library Recommendation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <div class="container mt-5 mb-5">
            <div class="card p-4 shadow">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $pencarian = trim(mysqli_real_escape_string($db, $_POST['kategori']));
                    if ($pencarian != "") {
                    ?>
                    <h3>Hasil rekomendasi untuk kata kunci: <span class='text-primary'><?php echo htmlspecialchars($pencarian) ?> </span></h3>
                    <div class="mt-4">
                        <form method="get">
                        <button class="btn btn-secondary" type="submit">Cari Lagi</button>
                        </form>
                    </div>
                <?php    
                    }
                } else {
                ?>
                    <h3 class="mb-4">Pilih kategori pada pilihan untuk mendapatkan rekomendasi</h3>
                    <form class="d-flex" role="search" method="post">
                        <select name="kategori" class="form-select" style="width: 250px; height: 40px;">
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
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
        <div class="container">
            <div class="row">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST" && $pencarian != "") {
                    $query = "
                    SELECT 
                        b.biblio_id, 
                        b.judul, 
                        b.kategori, 
                        b.penulis, 
                        b.tahun, 
                        COUNT(m.consequents_id) AS borrowed_count
                    FROM 
                        buku b
                    LEFT JOIN 
                        model m ON m.consequents_id = b.biblio_id
                    WHERE 
                        m.antecedents_id IN (
                            SELECT DISTINCT biblio_id 
                            FROM buku 
                            WHERE judul LIKE '%$pencarian%'
                        )
                    GROUP BY 
                        b.biblio_id
                    ORDER BY 
                        borrowed_count DESC, 
                        b.kategori ASC
                ";
                

                    $q_tampil_rekomendasi = mysqli_query($db, $query);

                    if (mysqli_num_rows($q_tampil_rekomendasi) > 0) {
                    ?>
                        <div class="row">
                            <?php
                            while ($r_tampil_rekomendasi = mysqli_fetch_array($q_tampil_rekomendasi)) {
                                $biblio_id = isset($r_tampil_rekomendasi['biblio_id']) ? $r_tampil_rekomendasi['biblio_id'] : null;
                            ?>
                                <div class="col-md-4"> <!-- Each book is in one column -->
                                    <a href="book_details.php?biblio_id=<?php echo $biblio_id; ?>" class="text-decoration-none text-dark"> <!-- Link to details page -->
                                        <div class="card" style="width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $r_tampil_rekomendasi['judul']; ?></h5>
                                                <p class="card-text">
                                                    <strong>Kategori: </strong> <?php echo $r_tampil_rekomendasi['kategori']; ?><br>
                                                    <strong>Penulis: </strong> <?php echo $r_tampil_rekomendasi['penulis']; ?><br>
                                                    <strong>Tahun: </strong> <?php echo $r_tampil_rekomendasi['tahun']; ?>
                                                </p>
                                            </div>
                                            <img class="card-img-top" src="gambar/vector-modern-book-cover-design-template_1050343-242-removebg-preview.png" alt="Book cover">
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php } else { ?>
                        <h3>Tidak ada rekomendasi untuk buku berjudul <span class='text-primary'><?php echo htmlspecialchars($pencarian); ?></span></h3>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            </div>
        </div>
</body>

</html>
