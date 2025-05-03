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
                            <label for="kode" class="form-label">kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" required>
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
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                        </div>
                        <div class="mb-3">
                            <input type="radio" class="form-check-control" id="gender" name="gender" value="L" required>
                            <label for="laki-laki" class="form-label">Laki-laki</label>
                            <input type="radio" class="form-check-control" id="gender" name="gender" value="P" required>
                            <label for="perempuan" class="form-label">Perempuan</label>
                        </div>
                        <div class="mb-3">
                            <label for="unit_kerja" class="form-label">Unit Kerja</label>
                            <select class="form-select" name="unit_kerja" id="unit_kerja">
                                <option value="" hidden>--Pilih Unit Kerja--</option>
                                <?php 
                                require_once 'Controllers/Unitkerja.php';
                                $unit = $unitkerja->index();
                                foreach ($unit as $item) : ?>
                                    <option value="<?php echo $item['id']; ?>"><?php echo $item['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="telepon" class="form-label">telepon</label>
                            <input type="number" class="form-control" id="telepon" name="telepon" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
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
                        <th>Nama Paramedik</th>
                        <th>Gender</th>
                        <th>Tanggal Lahir</th>
                        <th>Kategori</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require ('Controllers/Paramedik.php');
                    $row = $paramedik->index();
                    $nomer=1;
                    foreach($row as $item){
                    ?>
                        <tr>
                            <td><?php echo$nomer++ ?></td>
                            <td><?php echo $item['nama']; ?></td>
                            <td><?php echo $item['gender'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                            <td><?php echo $item['tgl_lahir']; ?></td>
                            <td><?php echo $item['kategori']; ?></td>
                            <td><?php echo $item['telepon']; ?></td>
                            <td><?php echo $item['alamat']; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="type" value="edit">
                                    <input type="submit" value="edit" class="btn btn-warning btn-sm">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="hidden" name="type" value="delete">
                                    <input type="submit" value="delete" class="btn btn-danger btn-sm">
                                </form>
                            </td>
                        </tr>
                    <?php } 
                    if(isset($_POST['type'])){
                        if($_POST['type'] == 'delete'){
                            $paramedik->delete($_POST['id']);
                            echo "<script>alert('Data berhasil dihapus.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=paramedik';</script>";
                        } elseif($_POST['type'] == 'add'){
                            $paramedik->create($_POST['kode'], $_POST['nama'], $_POST['tmp_lahir'], $_POST['tgl_lahir'], $_POST['gender'], $_POST['email'], $_POST['alamat'], $_POST['kelurahan_id']);
                            echo "<script>alert('Data berhasil ditambahkan.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=paramedik';</script>";
                        } elseif ($_POST['type'] == 'edit') {
                            $id = $_POST['id'];
                            $stmt = $paramedik->show($id);
                            $item = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($item) {
                                echo '<form method="POST" action="" class="justify-content-center row text-center">
                                <div class="col-6 card shadow p-3 mb-5 bg-white rounded align-self-center">
                                    <h3 class="text-center">Edit Data</h3>
                                    <input type="hidden" name="type" value="update">
                                    <input type="hidden" name="id" value="' . htmlspecialchars($item['id']) . '">
                                    <div class="mb-3">
                                        <label for="kode" class="form-label">Kode</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['kode']) . '" id="kode" name="kode" required>
                                    </div>
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
                                        <input type="date" class="form-control" value="' . htmlspecialchars($item['tgl_lahir']) . '" id="tgl_lahir" name="tgl_lahir" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">gender</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['gender']) . '" id="gender" name="gender" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">email</label>
                                        <input type="email" class="form-control" value="' . htmlspecialchars($item['email']) . '" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">alamat</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['alamat']) . '" id="alamat" name="alamat" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelurahan_id" class="form-label">kelurahan</label>
                                            <select class="form-select" name="kelurahan_id" id="kelurahan_id">
                                                <option value="" hidden>--Pilih Kelurahan--</option>';
                                                $kelurahan = $kelurahan->index();
                                                foreach ($kelurahan as $lurah) {
                                                 echo "<option value='{$lurah['id']}' "; 
                                                 echo $lurah['id']==htmlspecialchars($item['kelurahan_id']) ? 'selected':'' ;
                                                 echo ">{$lurah['nama']}</option>";
                                                    //echo "<option value='{$lurah['id']}'>{$lurah['nama']}</option>";
                                                }
                                            echo '</select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                                </form>';
                            } else {
                                echo "Item not found.";
                            }
                        } elseif ($_POST['type'] == 'update') {
                            $id = $_POST['id'];
                            $data = [
                                'kode' => $_POST['kode'],
                                'nama' => $_POST['nama'],
                                'tmp_lahir' => $_POST['tmp_lahir'],
                                'tgl_lahir' => $_POST['tgl_lahir'],
                                'gender' => $_POST['gender'],
                                'email' => $_POST['email'],
                                'alamat' => $_POST['alamat'],
                                'kelurahan_id' => $_POST['kelurahan_id']
                            ];
                            $paramedik->update($id, $data);
                            echo "<script>
                                window.location.href = 'dashboard.php?url=paramedik';
                            </script>";
                        }
                    } 
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
