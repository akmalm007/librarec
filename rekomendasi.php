<?php
include 'koneksi.php';
?>
<!doctype html>
<html>

<head>
    <title>Rekomendasi Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container">
        <div class="row">
            <form CLASS="form-inline" method="POST">
                <div align="">
                    <form method=post>
                        <fieldset>
                            <label>
                                Search
                                <input type="text" name="pencarian" value="<?php echo isset($_POST['pencarian']) ? htmlentities($_POST['pencarian']) : ''; ?>">
                                <input type="submit" name="search" value="search" class="tombol">
                                <input type="reset" name="reset" value="clear">
                            </label>
                        </fieldset>
                    </form>
                </div>
            </form>
        </div>

        <div class="row">
            <h1>Rekomendasi Buku</h1>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $pencarian = trim(mysqli_real_escape_string($db, $_POST['pencarian']));

                if ($pencarian != "") {

                    $query = "SELECT b.biblio_id, b.judul, b.kategori, b.penulis, b.tahun FROM buku b 
                    LEFT JOIN model m ON m.consequents_id = b.biblio_id  
                    WHERE m.antecedents_id IN (SELECT DISTINCT biblio_id FROM buku WHERE judul LIKE '%$pencarian%') GROUP BY b.biblio_id";

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
                                            <img class="card-img-top" src="gambar/vector-modern-book-cover-design-template_1050343-242-removebg-preview.png" alt="Book cover">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $r_tampil_rekomendasi['judul']; ?></h5>
                                                <p class="card-text">
                                                    Kategori Buku: <?php echo $r_tampil_rekomendasi['kategori']; ?><br>
                                                    Penulis Buku: <?php echo $r_tampil_rekomendasi['penulis']; ?><br>
                                                    Tahun Terbit: <?php echo $r_tampil_rekomendasi['tahun']; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php } else {
                    ?>
                        <h3>Tidak ada rekomendasi untuk buku berjudul <?php echo $_POST['pencarian']; ?></h3>
                    <?php
                    } ?>
            <?php
                }
            }
            ?>

        </div>
    </div>
</body>

</html>
