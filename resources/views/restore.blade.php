
<section class="section">
<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-10 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Restore</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                      <tr>
              <th>No</th>
              <th>Nama Kelas</th>
              <th>Posisi Kelas</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
                      </thead>
                      <tbody>
                      <?php
            $no = 1;
            foreach ($yoga as $key) {
            ?>
                        <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $key->nama_kelas ?></td>
                        <td><?= $key->posisi_kelas ?></td>
                        <td><?= $key->status ?></td>

                        <td>
                  <a href="{{ url('home/soft_delete/' . $key->id_kelas) }}">
                    <button class="btn btn-info">
                      <i class="now-ui-icons ui-1_check"></i> Restore
                    </button>
                  </a>
                  <a href="{{ url('home/hapus_permanent/' . $key->id_kelas) }}">
                    <button class="btn btn-danger">
                      <i class="now-ui-icons ui-1_check"></i> Delete
                    </button>
                  </a>
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
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
<!-- partial -->
