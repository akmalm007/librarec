<?php 
include 'koneksi.php';
?>
<head>
    <title>Librec: Library Recommendation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<form class="row g-3 align-items-center" role="search" method="get" action="#koleksi">
    <!-- Search Input -->
    <div class="col-md-6">
        <div class="input-group">
            <input 
                name="pencarian" 
                type="search" 
                class="form-control" 
                placeholder="Cari Judul Buku, atau Kategori Buku" 
                aria-label="Search"
                value="<?php echo isset($_GET['pencarian']) ? htmlspecialchars($_GET['pencarian']) : ''; ?>"
            >
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
