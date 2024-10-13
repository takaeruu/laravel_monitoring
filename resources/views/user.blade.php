<section class="section">
    <div class="row" id="basic-table">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">USER</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no = 1;
                                    foreach ($user as $key) { // 'kelas' dari controller
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $key->username ?></td>
                                        <td><?= $key->status ?></td>
                                        <td>
                                            
                                                <a href="<?= url('home/aksi_reset_password/' . $key->id_user) ?>" class="btn btn-danger">
                                                    <i class="now-ui-icons ui-1_check"></i> Reset Password
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
