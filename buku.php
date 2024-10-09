<?php
include 'koneksi.php';
?>
<html>

<head>
    <title>
        Data Buku
    </title>
</head>

<body>
    <p>

    <form CLASS="form-inline" method="POST">
        <div align="">
            <form method=post><input type="text" name="pencarian"><input type="submit" name="search" value="search" class="tombol"></form>
    </form>
    </p>
    <table>
        <tr>
            <th>Biblio ID</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Penulis</th>
            <th>Tahun</th>
        </tr>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pencarian = trim(mysqli_real_escape_string($db, $_POST['pencarian']));
            if ($pencarian != "") {
                $sql = "SELECT * FROM buku WHERE judul LIKE '%$pencarian%'";
                $query = $sql;
            } else {
                $query = "SELECT * FROM buku";
            }
        } else {
            $query = "SELECT * FROM buku";
        };

        $q_tampil_buku = mysqli_query($db, $query);
        if (mysqli_num_rows($q_tampil_buku) > 0) {
            while ($r_tampil_buku = mysqli_fetch_array($q_tampil_buku)) {
        ?>
                <tr>
                    <td><?php echo $r_tampil_buku['biblio_id']; ?></td>
                    <td><?php echo $r_tampil_buku['judul']; ?></td>
                    <td><?php echo $r_tampil_buku['kategori']; ?></td>
                    <td><?php echo $r_tampil_buku['penulis']; ?></td>
                    <td><?php echo $r_tampil_buku['tahun']; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </table>

</body>

</html>
