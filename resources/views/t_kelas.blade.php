<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12"> <!-- Full width for the form -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Kelas</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ url('home/aksi_t_kelas') }}" method="POST">
                            @csrf <!-- CSRF token for security -->
                            <div class="form-body">
                                <div class="row">
                                    <!-- Nama Kelas -->
                                    <div class="col-md-4"> <!-- Label column -->
                                        <label for="nama_kelas">Nama Kelas</label>
                                    </div>
                                    <div class="col-md-8 form-group"> <!-- Input column -->
                                        <input type="text" id="nama_kelas" class="form-control form-control-lg" name="namakelas" placeholder="Nama Kelas" required>
                                    </div>

                                    <!-- Posisi Kelas -->
                                    <div class="col-md-4"> <!-- Label column -->
                                        <label for="posisikelas">Posisi Kelas</label>
                                    </div>
                                    <div class="col-md-8 form-group"> <!-- Input column -->
                                        <input type="text" id="posisikelas" class="form-control form-control-lg" name="posisikelas" placeholder="Posisi Kelas" required>
                                    </div>

                                    <!-- Jenis Kelas -->
                                    <div class="col-md-4"> <!-- Label column -->
                                        <label for="jeniskelas">Jenis Kelas</label>
                                    </div>
                                   
                                    <!-- Submit and Reset Buttons -->
                                    <div class="col-sm-12 d-flex justify-content-end mt-3"> <!-- Button alignment -->
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
