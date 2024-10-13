<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">KELAS KELAS SPH</h4>
                </div>
                <a class="nav-link text-Headings my-2" href="{{ url('home/tambah_kelas') }}">
                            <span class="btn btn-warning">Tambah Kelas</span>
                        </a>
                <div class="card-content">
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Posisi Kelas</th>
                                        <th>Admin ruangan</th>
                                        <th>Pilih Admin Ruangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no = 1;
                                    foreach ($kelas as $key) { // 'kelas' dari controller
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $key->nama_kelas ?></td>
                                        <td><?= $key->posisi_kelas ?></td>
                                        <td><?= $key->username ?? 'Belum ada Admin ruangan' ?></td>
                                        <td>
                                            <!-- Dropdown untuk memilih user -->
                                            <form action="<?= url('home/aksi_set_admin') ?>" method="POST">
    <?= csrf_field() ?>
    <input type="hidden" name="id_kelas" value="<?= $key->id_kelas ?>">
    <select class="form-control" name="id_user" required>
        <option value="">Pilih</option>
        <?php foreach ($user as $u): ?>
            <option value="<?= $u->id_user ?>"><?= $u->username ?></option>
        <?php endforeach; ?>
    </select>
    <td>
    <button type="submit" class="btn btn-warning mt-2">
        <i class="now-ui-icons ui-1_check"></i> Set Admin Ruangan
    </button>
    </td>
</form>
<td>
    <form action="<?= url('home/aksi_set_admin_null') ?>" method="POST" style="display: inline;">
        <?= csrf_field() ?>
        <input type="hidden" name="id_kelas" value="<?= $key->id_kelas ?>"> <!-- Mengirim id_kelas untuk dihapus adminnya -->
        <button type="submit" class="btn btn-danger mt-2">
            <i class="now-ui-icons ui-1_check"></i> Remove Admin Ruangan
        </button>
    </form>
</td>

                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
