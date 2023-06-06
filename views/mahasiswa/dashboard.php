<div class="card mt-4 mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mata Kuliah</th>
                        <th>Mahasiswa</th>
                        <th>Tugas</th>
                        <th>File</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Mata Kuliah</th>
                        <th>Mahasiswa</th>
                        <th>Tugas</th>
                        <th>File</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $pengguna_id = $_SESSION['id'];
                    // Query untuk mendapatkan data mahasiswa
                    $query = "SELECT pg.id, p.nama AS 'nama_mahasiswa', mk.nama AS 'nama_matkul', pen.nama AS 'nama_penugasan', pg.file_penugasan AS 'file_penugasan', pg.nilai AS 'nilai'
                    FROM pengumpulan pg
                    JOIN pengguna p ON p.id = pg.mahasiswa_id AND p.peran = 'mahasiswa'
                    JOIN penugasan pen ON pen.id = pg.penugasan_id
                    JOIN matakuliah mk ON mk.id = pen.mata_kuliah_id
                    WHERE p.id = $pengguna_id";

                    $result = mysqli_query($koneksi, $query);

                    // Jumlah baris data
                    $jumlahData = mysqli_num_rows($result);
                    if ($jumlahData > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {

                    ?>
                            <tr>
                                <td class="align-middle"><?php echo $no; ?></td>
                                <td class="align-middle"><?php echo $row['nama_matkul']; ?></td>
                                <td class="align-middle"><?php echo $row['nama_mahasiswa']; ?></td>
                                <td class="align-middle"><?php echo $row['nama_penugasan']; ?></td>
                                <td class="align-middle"><?php echo $row['file_penugasan']; ?></td>
                                <td class="align-middle"><?php echo $row['nilai']; ?></td>

                                <td class="align-middle">
                                    <a href="uploads/?php echo $row['file_penugasan']; ?>" download="<?php echo $row['file_penugasan']; ?>" class="btn btn-outline-info mr-2">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $no++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" class="text-center align-middle">Data Not Available</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>