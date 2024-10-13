<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profile</h5>
                        <div class="row">
                            <!-- Foto Profile -->
                            <div class="col-md-4 text-center mb-5">
                                <?php
                                    $foto_profil = ($darren->foto) ? asset('img/' . $darren->foto) : asset('img/user.png');
                                ?>
                                <img src="<?= $foto_profil ?>" class="rounded-circle" style="width: 200px; height: 200px;" alt="Foto Profile"><br><br>
                                <form action="<?= url('home/aksi_edit_foto') ?>" method="post" enctype="multipart/form-data">
                                    <?= csrf_field() ?> <!-- Tambahkan token CSRF -->
                                    <label for="foto" class="btn btn-warning px-3">Pilih Foto Profil Baru</label><br>
                                    <input class="file-input" type="file" id="foto" name="foto" accept="image/*" style="display: none;">
                                    <span id="file-name"></span> 
                                    <br>
                                    <button id="saveButton" class="btn btn-warning px-3" style="height: 40px; display: none;">Save</button>
                                </form>
                            </div>
                            <!-- Form Profile -->
                            <div class="col-md-8">
                                <form action="{{ url('home/aksi_e_profile') }}" method="POST">
                                    <?= csrf_field() ?> <!-- Tambahkan token CSRF -->
                                    <input type="hidden" name="id" value="<?= $darren->id_user ?>">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="username">Username</label>
                                            <input type="text" id="username" class="form-control" name="username" value="<?= $darren->username ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="email">Status</label>
                                            <input type="text" id="email" class="form-control" name="email" value="<?= $darren->status ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-12 offset-md-4 mt-4">
                                            <a href="<?= url('home/logout') ?>" class="btn btn-lg btn-danger">
                                                <i class="mdi mdi-logout"></i> Log Out
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Script untuk menampilkan nama file yang di-upload
    document.getElementById('foto').onchange = function() {
        var fileName = this.value.split('\\').pop();
        document.getElementById('file-name').innerText = 'File : ' + fileName;
        document.getElementById('saveButton').style.display = 'inline-block';
    };

    // Script untuk toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleButton.innerHTML = '<i class="mdi mdi-eye-off"></i>'; // Ubah ikon mata jika password terlihat
        } else {
            passwordField.type = 'password';
            toggleButton.innerHTML = '<i class="mdi mdi-eye"></i>'; // Ubah ikon mata jika password tersembunyi
        }
    });
</script>
