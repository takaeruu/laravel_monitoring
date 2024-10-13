<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Izin Kelas</h4>
                        
                        <!-- Pastikan token CSRF sudah ditambahkan -->
                        <form action="<?= url('home/aksi_izin_kelas'); ?>" method="POST">
                            <?= csrf_field() ?>
                            
                            <input type="hidden" name="id" value="<?= $dua->id_kelas ?>">

                            <!-- Menampilkan nama kelas dan posisi kelas -->
                            <div class="form-group">
                                <label for="exampleInputUsername1">Nama Kelas</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" name="namakelas" value="<?= $dua->nama_kelas ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Posisi Kelas</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="posisikelas" value="<?= $dua->posisi_kelas ?>" readonly>
                            </div>
                            <div class="form-group">
    <label for="sesi">Sesi</label>
    <select class="form-control" id="sesi" name="sesi" required>
        <option value="">-- Pilih Sesi --</option> <!-- Option kosong untuk pemilihan awal -->
        <option value="Sesi 1">Sesi 1</option>
        <option value="Sesi 2">Sesi 2</option>
        <option value="Sesi 3">Sesi 3</option>
        <option value="Sesi 4">Sesi 4</option>
        <option value="Sesi 5">Sesi 5</option>
    </select>
</div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Keperluan</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="keperluan"  required>
                            </div>
                           

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
