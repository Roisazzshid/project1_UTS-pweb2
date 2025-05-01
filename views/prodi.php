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
                            <label for="kode" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="kaprodi" class="form-label">Kaprodi</label>
                            <input type="text" class="form-control" id="kaprodi" name="kaprodi" required>
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
                <th>Kode</th>
                <th>Nama</th>
                <th>Kaprodi</th>
                <th colspan="2">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    require ('Controllers/Prodi.php');
                    $row = $prodi->index();
                    $nomer=1;
                    foreach($row as $item){
                    ?>
                        <tr>
                            <td><?php echo$nomer++ ?></td>
                            <td><?php echo $item['kode']; ?></td>
                            <td><?php echo $item['nama']; ?></td>
                            <td><?php echo $item['kaprodi']; ?></td>
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
                            $prodi->delete($_POST['id']);
                            echo "<script>alert('Data berhasil dihapus.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=prodi';</script>";
                        } elseif($_POST['type'] == 'add'){
                            $prodi->create($_POST['kode'], $_POST['nama'], $_POST['kaprodi']);
                            echo "<script>alert('Data berhasil ditambahkan.');</script>";
                            echo "<script>window.location.href = 'dashboard.php?url=prodi';</script>";
                        } elseif ($_POST['type'] == 'edit') {
                            $id = $_POST['id'];
                            $stmt = $prodi->show($id);
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
                                        <label for="kaprodi" class="form-label">Kaprodi</label>
                                        <input type="text" class="form-control" value="' . htmlspecialchars($item['kaprodi']) . '" id="kaprodi" name="kaprodi" required>
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
                                'kaprodi' => $_POST['kaprodi']
                            ];
                            $prodi->update($id, $data);
                            echo "<script>
                                window.location.href = 'dashboard.php?url=prodi';
                            </script>";
                        }
                    } 
                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
