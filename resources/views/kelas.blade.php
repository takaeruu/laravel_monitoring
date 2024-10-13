<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">KELAS KELAS SPH</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kelas</th>
                                        <th>Posisi Kelas</th>
                                        <th>Status</th>
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
                                        <td><?= $key->status ?></td>
                                        <td>
                                            <?php if ($key->status === "Sedang di Pakai") { ?>
                                                <button class="btn btn-warning" onclick="alert('Kelas ini sedang dipakai!')">
                                                    <i class="now-ui-icons ui-1_check"></i> Pakai
                                                </button>
                                            <?php } else { ?>
                                                <a href="<?= url('home/izin_kelas/' . $key->id_kelas) ?>" class="btn btn-warning">
                                                    <i class="now-ui-icons ui-1_check"></i> Pakai
                                                </a>
                                            <?php } ?>
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
