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
                            <label for="pasien_id" class="form-label">Nama Pasien</label>
                            <select class="form-select" name="pasien_id" id="pasien_id" required>
                                    <option value="" hidden>--Pilih Pasien--</option>
                                    <?php 
                                    require_once 'Controllers/Pasien.php';
                                    $pasiens = $pasien->index();
                                    foreach ($pasiens as $pasien){
                                        echo "<option value='{$pasien['id']}'";

                                        if(isset($row) && $row['nama_pasien'] == $pasien['nama']) echo " selected";

                                        echo ">{$pasien['nama']}</option>";
                                    }?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="paramedik_id" class="form-label">Nama Paramedik</label>
                            <select class="form-select" name="paramedik_id" id="paramedik_id" required>
                                    <option value="" hidden>--Pilih Paramedik--</option>
                                    <?php 
                                    require_once 'Controllers/Paramedik.php';
                                    $paramediks = $paramedik->index();
                                    foreach ($paramediks as $paramedik){
                                        echo "<option value='{$paramedik['id']}'";

                                        if(isset($row) && $row['nama_paramedik'] == $paramedik['nama']) echo " selected";

                                        echo ">{$paramedik['nama']}</option>";
                                    }?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="berat" class="form-label">Berat Badan</label>
                            <input type="number" class="form-control" id="berat" name="berat" required>
                        </div>
                        <div class="mb-3">
                            <label for="tinggi" class="form-label">Tinggi Badan</label>
                            <input type="number" class="form-control" id="tinggi" name="tinggi" required>
                        </div>
                        <div class="mb-3">
                            <input class="form-control" type="number" name="sistolik" placeholder="Sistolik" value="<?= isset($item) ? explode('/', $item['tensi'])[0] : ''; ?>" required>
                            <span class="text-slash">/</span>
                            <input class="form-control" type="number" name="diastolik" placeholder="Diastolik" value="<?= isset($item) ? explode('/', $item['tensi'])[1] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan Pasien"></textarea>
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
                        <th style="width: 15px;">No</th>
                        <th>Tanggal</th>
                        <th>Pasien</th>
                        <th>Paramedik</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require ('Controllers/Periksa.php');
                    $row = $periksa->index();
                    $nomer=1;
                    foreach($row as $item){
                    ?>
                        <tr>
                            <td><?php echo$nomer++ ?></td>
                            <td><?php echo $item['tanggal']; ?></td>
                            <td><?php echo $item['nama_pasien']; ?></td>
                            <td><?php echo $item['nama_paramedik']; ?></td>
                            <td><?php echo $item['keterangan']; ?></td>
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
                            $periksa->delete($_POST['id']);
                            echo "<script>alert('Data berhasil dihapus.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=periksa';</script>";
                        } elseif($_POST['type'] == 'add'){
                            $tensi = $_POST['sistolik'] . '/' . $_POST['diastolik'];
                            $periksa->create($_POST['pasien_id'], $_POST['paramedik_id'], $_POST['berat'], $_POST['tinggi'], $tensi, $_POST['tanggal'], $_POST['keterangan']);
                            echo "<script>alert('Data berhasil ditambahkan.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=periksa';</script>";
                        } elseif ($_POST['type'] == 'edit') {
                            $id = $_POST['id'];
                            $stmt = $periksa->show($id);
                            $item = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($item) {
                                echo '<form method="POST" action="" class="justify-content-center row text-center">
                                <div class="col-6 card shadow p-3 mb-5 bg-white rounded align-self-center">
                                    <h3 class="text-center">Edit Data</h3>
                                    <input type="hidden" name="type" value="update">
                                    <input type="hidden" name="id" value="' . htmlspecialchars($item['id']) . '">
                                    <div class="mb-3">
                                        <label for="nama_pasien" class="form-label">nama pasien</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['nama_pasien']) . '" id="nama_pasien" name="nama_pasien" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_paramedik" class="form-label">nama_paramedik</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['nama_paramedik']) . '" id="nama_paramedik" name="nama_paramedik" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="berat" class="form-label">berat</label>
                                        <input type="number" class="form-control" value="' . htmlspecialchars($item['berat']) . '" id="berat" name="berat" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tinggi" class="form-label">tinggi</label>
                                        <input type="number" class="form-control" value="' . htmlspecialchars($item['tinggi']) . '" id="tinggi" name="tinggi" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tensi" class="form-label">tensi</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['tensi']) . '" id="tensi" name="tensi" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">tanggal</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['tanggal']) . '" id="tanggal" name="tanggal" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">keterangan</label>
                                        <textarea class="form-control" value="' . htmlspecialchars($item['keterangan']) . '" name="keterangan" id="keterangan"></textarea>
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
                                'pasien_id' => $_POST['pasien_id'],
                                'paramedik_id' => $_POST['paramedik_id'],
                                'berat' => $_POST['berat'],
                                'tinggi' => $_POST['tinggi'],
                                'tensi' => $_POST['tensi'],
                                'tanggal' => $_POST['tanggal'],
                                'keterangan' => $_POST['keterangan']
                            ];
                            $periksa->update($id, $data);
                            echo "<script>
                                window.location.href = 'dashboard.php?url=periksa';
                            </script>";
                        }
                    } 
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
