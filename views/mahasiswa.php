<div class="container">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="nim" class="form-label">nim</label>
                            <input type="number" class="form-control" id="nim" name="nim" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="tmp_lahir" class="form-label">tmp_lahir</label>
                            <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_lahir" class="form-label">tgl_lahir</label>
                            <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="thn_masuk" class="form-label">thn_masuk</label>
                            <input type="number" class="form-control" id="thn_masuk" name="thn_masuk" required>
                        </div>
                        <div class="mb-3">
                            <label for="sks_lulus" class="form-label">sks_lulus</label>
                            <input type="number" class="form-control" id="sks_lulus" name="sks_lulus" required>
                        </div>
                        <div class="mb-3">
                            <label for="ipk" class="form-label">ipk</label>
                            <input type="number" class="form-control" id="ipk" name="ipk" required>
                        </div>
                        <input type="hidden" name="type" value="add">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Tambah Data
            </button>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Email</th>
                <th>Tahun Masuk</th>
                <th>SKS Lulus</th>
                <th>IPK</th>
                <th>Prodi</th>
                <th colspan="2">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    require ('Controllers/Mahasiswa.php');
                    $row = $mahasiswa->index();
                    $nomer=1;
                    foreach($row as $item){
                    ?>
                        <tr>
                            <td><?php echo$nomer++ ?></td>
                            <td><?php echo $item['nim']; ?></td>
                            <td><?php echo $item['nama']; ?></td>
                            <td><?php echo $item['tmp_lahir']; ?></td>
                            <td><?php echo $item['tgl_lahir']; ?></td>
                            <td><?php echo $item['email']; ?></td>
                            <td><?php echo $item['thn_masuk']; ?></td>
                            <td><?php echo $item['sks_lulus']; ?></td>
                            <td><?php echo $item['ipk']; ?></td>
                            <td><?php echo $item['prodi_id']; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="nim" value="<?php echo $item['nim']; ?>">
                                    <input type="hidden" name="type" value="edit">
                                    <input type="submit" value="edit" class="btn btn-warning btn-sm">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="nim" value="<?php echo $item['nim']; ?>">
                                    <input type="hidden" name="type" value="delete">
                                    <input type="submit" value="delete" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        </tr>
                    <?php } 
                    if(isset($_POST['type'])){
                        if($_POST['type'] == 'delete'){
                            $mahasiswa->delete($_POST['nim']);
                            echo "<script>alert('Data berhasil dihapus.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=mahasiswa';</script>";
                        } elseif($_POST['type'] == 'add'){
                            $mahasiswa->create($_POST['nim'], $_POST['nama'], $_POST['tmp_lahir'], $_POST['tgl_lahir'], $_POST['email'], $_POST['thn_masuk'], $_POST['sks_lulus'], $_POST['ipk'], $_POST['prodinim']);
                            echo "<script>alert('Data berhasil ditambahkan.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=mahasiswa';</script>";
                        } elseif ($_POST['type'] == 'edit') {
                            $nim = $_POST['nim'];
                            $stmt = $mahasiswa->show($nim);
                            $item = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($item) {
                                echo '<form method="POST" action="" class="justify-content-center row text-center">
                                <div class="col-6 card shadow p-3 mb-5 bg-white rounded align-self-center">
                                    <h3 class="text-center">Edit Data</h3>
                                    <input type="hidden" name="type" value="update">
                                    <input type="hidden" name="nim" value="' . htmlspecialchars($item['nim']) . '">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['nama']) . '" id="nama" name="nama" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tmp_lahir" class="form-label">tmp_lahir</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['tmp_lahir']) . '" id="tmp_lahir" name="tmp_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_lahir" class="form-label">tgl_lahir</label>
                                        <input type="number" class="form-control" value="' . htmlspecialchars($item['tgl_lahir']) . '" id="tgl_lahir" name="tgl_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">email</label>
                                        <input type="email" class="form-control" value="' . htmlspecialchars($item['email']) . '" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="thn_masuk" class="form-label">thn_masuk</label>
                                        <input type="number" class="form-control" value="' . htmlspecialchars($item['thn_masuk']) . '" id="thn_masuk" name="thn_masuk" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sks_lulus" class="form-label">sks_lulus</label>
                                        <input type="number" class="form-control" value="' . htmlspecialchars($item['sks_lulus']) . '" id="sks_lulus" name="sks_lulus" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ipk" class="form-label">ipk</label>
                                        <input type="number" class="form-control" value="' . htmlspecialchars($item['ipk']) . '" id="ipk" name="ipk" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prodi_id" class="form-label">prodi_id</label>
                                        <input type="number" class="form-control" value="' . htmlspecialchars($item['prodi_id']) . '" id="prodi_id" name="prodi_id" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                                </form>';
                            } else {
                                echo "Item not found.";
                            }
                        } elseif ($_POST['type'] == 'update') {
                            $nim = $_POST['nim'];
                            $data = [
                                'nama' => $_POST['nama'],
                                'tmp_lahir' => $_POST['tmp_lahir'],
                                'tgl_lahir' => $_POST['tgl_lahir'],
                                'email' => $_POST['email'],
                                'thn_masuk' => $_POST['thn_masuk'],
                                'sks_lulus' => $_POST['sks_lulus'],
                                'ipk' => $_POST['ipk'],
                                'prodi_id' => $_POST['kaprodi']
                            ];
                            $mahasiswa->update($nim, $data);
                            echo "<script>
                                window.location.href = 'dashboard.php?url=mahasiswa';
                            </script>";
                        }
                    } 
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
