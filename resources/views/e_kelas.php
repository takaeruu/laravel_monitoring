<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Izin Kelas</h4>
                        
                        <!-- Pastikan token CSRF sudah ditambahkan -->
                        <form action="<?= url('home/aksi_e_kelas'); ?>" method="POST">
                            <?= csrf_field() ?>
                            
                            <input type="hidden" name="id" value="<?= $dua->id_kelas ?>">

                            <!-- Menampilkan nama kelas dan posisi kelas -->
                            <div class="form-group">
                                <label for="exampleInputUsername1">Nama Kelas</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" name="namakelas" value="<?= $dua->nama_kelas ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Posisi Kelas</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="posisikelas" value="<?= $dua->posisi_kelas ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <!-- Option values -->
                                    <option value="Sedang di Pakai" <?= $dua->status == "Sedang di Pakai" ? 'selected' : '' ?>>Sedang di Pakai</option>
                                    <option value="Pending" <?= $dua->status == "Pending" ? 'selected' : '' ?>>Pending</option>
                                    <option value="Kosong" <?= $dua->status == "Kosong" ? 'selected' : '' ?>>Kosong</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
