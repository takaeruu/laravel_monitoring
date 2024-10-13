
<section class="section">
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Kelas</h4>
                        

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
@foreach ($all_classes as $key)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $key->nama_kelas }}</td>
        <td>{{ $key->posisi_kelas }}</td>
        <td>{{ $key->status }}</td>
        <td>
            <a href="{{ url('home/edit_kelas/' . $key->id_kelas) }}">
                <button class="btn btn-warning">
                    <i class="now-ui-icons ui-1_check"></i> Edit
                </button>
            </a>
            <a href="{{ url('home/hapus_kelas/' . $key->id_kelas) }}">
                <button class="btn btn-danger">
                    <i class="now-ui-icons ui-1_check"></i> Delete
                </button>
            </a>
        </td>
    </tr>
@endforeach
</tbody>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second table for izin kelas -->
        <div class="row mt-4">
            <div class="col-lg-10 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Pengguna dengan Izin Kelas</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Peminjam</th>
                                        <th>Sesi</th>
                                        <th>Keperluan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
@if (!empty($yoga)) 
    @foreach ($yoga as $kelas) 
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $kelas->username }}</td>
            <td>{{ $kelas->sesi }}</td>
            <td>{{ $kelas->keperluan }}</td>
            <td>{{ $kelas->kelasstatus }}</td>
            <td>
               
            <form action="<?= url('home/aksi_izinkan_kelas') ?>" method="POST" >
    <?= csrf_field() ?>
    <input type="hidden" name="id_kelas" value="<?= $key->id_kelas ?>">
    <button class="btn btn-success">
        <i class="now-ui-icons ui-1_check"></i> Izinkan
    </button>
</form>

<form action="<?= url('home/aksi_tolak_kelas') ?>" method="POST" >
    <?= csrf_field() ?>
    <input type="hidden" name="id_kelas" value="<?= $key->id_kelas ?>">
    <button class="btn btn-danger">
        <i class="now-ui-icons ui-1_check"></i> Tolak
    </button>
</form>
<form action="<?= url('home/aksi_selesai_kelas') ?>" method="POST" >
    <?= csrf_field() ?>
    <input type="hidden" name="id_kelas" value="<?= $key->id_kelas ?>">
                    <button class="btn btn-warning">
                        <i class="now-ui-icons ui-1_check"></i> Selesai
                    </button>
                    </form>
            </td>
        </tr>
    @endforeach 
@else 
    <tr>
        <td colspan="7" class="text-center">Tidak ada data izin kelas yang tersedia.</td>
    </tr>
@endif 
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
            Copyright © 2021. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.
        </span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
            Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i>
        </span>
    </div>
</footer>
<!-- partial -->
