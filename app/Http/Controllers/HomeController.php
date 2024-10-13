<?php

namespace App\Http\Controllers;

use App\Models\M_projek; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;

class HomeController extends BaseController
{
    public function dashboard()
    {
        if (session()->get('id') > 0) {
            $model = new M_projek();
            $data['jumlahKelasKosong'] = $model->countKelasKosong();
            $data['jumlahKelasPenuh'] = $model->countKelasPenuh();
            $data['jumlahKelas'] = $model->countKelas();

            $where = ['id_setting' => 1]; 
            $data['yogi'] = $model->getWhere2('setting', $where); 

        echo view('header', $data);
        echo view('menu', $data);
        echo view('dashboard', $data);
        echo view('footer');
    } else {
        return redirect()->to('home/login');
    }
    }

    public function login()
    {
        // Instantiate the model
        $model = new M_projek();
        
        // Define the criteria to fetch the settings
        $where = ['id_setting' => 1]; 
        $data['yogi'] = $model->getWhere2('setting', $where); 
        
        // Check if the record exists
        if (!$data['yogi']) {
            // Handle case where no record was found (optional)
            return redirect()->back()->with('error', 'Setting not found');
        }
    
        // Render the header and login view, passing the $data
        echo view('header', $data);
        echo view('login', $data); // Pass the data to the login view as well
    }
    

    

    public function aksi_login(Request $request)
{
    // Check internet connection
    if (!$this->checkInternetConnection()) {
        // If no internet connection, check CAPTCHA image
        if (session('captcha_code') !== $request->captcha_code) {
            return redirect()->route('login')
                ->with('toast_message', 'Invalid CAPTCHA')
                ->with('toast_type', 'danger');
        }
    } else {
        // Verify Google reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $secret = '6Ldon1YqAAAAAEaNmXJ_KPUN-Q6JA3CC10sesive'; // Replace with your Secret Key

        $response = Http::withOptions(['verify' => false])->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $recaptchaResponse,
        ]);

        $status = json_decode($response, true);

        if (!$status['success']) {
            return redirect()->to('home/login')
                ->with('toast_message', 'Captcha validation failed')
                ->with('toast_type', 'danger');
        }
    }

    // Normal login process
    $u = $request->username;
    $p = $request->password;

    $where = [
        'username' => $u,
        'password' => md5($p),
    ];

    // Get user using the User model
    $user = M_projek::getWhere('user',$where); // Call the static method

    if ($user) {
        session()->put([
            'nama' => $user->username, 
            'id' => $user->id_user, 
            'status' => $user->status, 
        ]);
        // dd(session()->all()); // Debug session
        return redirect()->to('home/dashboard');
        
    } else {
        return redirect()->to('home/login');
        // print_r($where);

}
}
public function generateCaptcha()
    {
        // Create a string of possible characters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $captcha_code = '';

        // Generate a random CAPTCHA code with letters and numbers
        for ($i = 0; $i < 6; $i++) {
            $captcha_code .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Store CAPTCHA code in session
        session()->set('captcha_code', $captcha_code);

        // Create an image for CAPTCHA
        $image = imagecreate(120, 40); // Increased size for better readability
        $background = imagecolorallocate($image, 200, 200, 200);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $line_color = imagecolorallocate($image, 64, 64, 64);

        imagefilledrectangle($image, 0, 0, 120, 40, $background);

        // Add some random lines to the CAPTCHA image for added complexity
        for ($i = 0; $i < 5; $i++) {
            imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $line_color);
        }

        // Add the CAPTCHA code to the image
        imagestring($image, 5, 20, 10, $captcha_code, $text_color);

        // Output the CAPTCHA image
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }

    public function checkInternetConnection()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected) {
            fclose($connected);
            return true;
        } else {
            return false;
        }
    }
    
    

    private function validateOfflineCaptcha($captchaInput)
    {
        $storedCaptcha = session()->get('captcha_code');
        return $captchaInput === $storedCaptcha; // Bandingkan input pengguna dengan CAPTCHA yang disimpan
    }

    // public function generateCaptcha()
    // {
    //     $code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);

    //     // Store the CAPTCHA code in the session
    //     session()->put('captcha_code', $code);

    //     // Generate the image
    //     $image = imagecreatetruecolor(120, 40);
    //     $bgColor = imagecolorallocate($image, 255, 255, 255);
    //     $textColor = imagecolorallocate($image, 0, 0, 0);

    //     imagefilledrectangle($image, 0, 0, 120, 40, $bgColor);
    //     imagestring($image, 5, 10, 10, $code, $textColor);

    //     // Set the content type header - in this case image/png
    //     header('Content-Type: image/png');

    //     // Output the image
    //     imagepng($image);

    //     // Free up memory
    //     imagedestroy($image);
    // }

    public function logout()
{
    // Clear all session data
    session()->flush();

    // Optionally, invalidate the session to ensure it cannot be reused
    request()->session()->invalidate();

    // Redirect to the login page
    return redirect()->to('home/login');
}

    public function profile()
    {
        if (session()->get('id') > 0) {

            $model = new M_projek;

            $where = array('id_user' => session()->get('id'));
            $data['darren'] = $model->getwhere('user', $where);
            $where = ['id_setting' => 1]; 
            $data['yogi'] = $model->getWhere2('setting', $where); 

            echo view('header', $data);
            echo view('menu', $data);
            echo view('profile', $data);
            echo view('footer');
        } else {
            return redirect()->to('home/login');
        }
    }

    public function aksi_edit_foto(Request $request)
    {
        // Dapatkan data user saat ini berdasarkan sesi
        $model = new M_projek();
        $userData = $model->getById(session()->get('id'));
    
        // Cek apakah file 'foto' ada dan valid
        $file = $request->file('foto');
        if ($file && $file->isValid()) {
    
            // Generate nama file baru yang acak
            $newFileName = $file->getClientOriginalName();
    
            // Pindahkan file ke direktori tujuan (public/img)
            $destinationPath = public_path('img');
            $file->move($destinationPath, $newFileName);
    
            // Hapus file lama jika ada
            if ($userData->foto && file_exists(public_path('img/' . $userData->foto))) {
                unlink(public_path('img/' . $userData->foto));
            }
    
            // Update data user dengan foto baru
            $userId = ['id_user' => session()->get('id')];
            $userData = ['foto' => $newFileName];
            $model->edit('user', $userData, $userId);
    
            // Redirect ke halaman profile dengan pesan sukses
            return redirect()->to('home/profile')->with('success', 'Foto profil berhasil diperbarui.');
        }
    
        // Jika tidak ada file atau file tidak valid, kembalikan dengan pesan error
        return redirect()->to('home/profile')->with('error', 'Tidak ada file yang di-upload atau file tidak valid.');
    }
    

        public function kelas()
        {
            $model = new M_projek();
            if (session()->get('id') > 0) {
            $data['kelas'] = M_projek::tampil('kelas');

            $where = ['id_setting' => 1]; 
            $data['yogi'] = $model->getWhere2('setting', $where); 

            echo view('header', $data);
            echo view('menu', $data);
            echo view('kelas', $data);
            echo view('footer'); 
        } else {
            return redirect()->to('home/login');
        }
        }

        public function tambah_kelas()
        {
            if (session()->get('id') > 0) {
                $model = new M_projek();
                $where = ['id_setting' => 1]; 
                $data['yogi'] = $model->getWhere2('setting', $where); 
            echo view('header', $data);
            echo view('menu', $data);
            echo view('t_kelas');
            echo view('footer'); 
        } else {
            return redirect()->to('home/login');
        }
        }


        public function aksi_t_kelas(Request $request) // Accepting Request as a parameter
{
    // Validate input
    $request->validate([
        'namakelas' => 'required|string|max:255',
        'posisikelas' => 'required|string|max:255',
    ]);

    // Get input values using the passed Request instance
    $nama_kelas = $request->input('namakelas'); // Get 'namakelas' input
    $posisi_kelas = $request->input('posisikelas');

    // Prepare the data for insertion
    $data = [
        'nama_kelas' => $nama_kelas,
        'posisi_kelas' => $posisi_kelas,
        'jenis_kelas' => 'Kelas',
        'status' => 'Kosong',
    ];

    // Create a new instance of M_projek and insert the data
    $model = new M_projek();
    $model->tambah('kelas', $data); // Use your method to add the data

    // Redirect to the kelas page with a success message
    return redirect()->to('home/kelas_akses')->with('success', 'Kelas berhasil ditambahkan!');
}

    



        public function kelas_admin()
{

    if (session()->get('id') > 0) {
    $model = new M_projek;

    // Get the current user's ID from the session
    $userId = session()->get('id');
    $allClasses = $model->where('id_user', $userId)->get();
    // Get all classes for the logged-in user
    $whereAllClasses = ['id_user' => $userId]; 
    $allClasses = $model->tampilWhere('kelas', $whereAllClasses);

    // Get filled classes with user information
    $whereFilledClasses = ['kelas.id_user' => $userId]; 
    $filledClasses = $model->joinKelasWithUser($whereFilledClasses);

    // Filter data to include only those with values in specific fields
    $filteredData = $filledClasses->filter(function ($kelas) {
        return !empty($kelas->id_penanggung) && 
               !empty($kelas->sesi) && 
               !empty($kelas->keperluan) && 
               !empty($kelas->status);
    });
    $where = ['id_setting' => 1]; 
    $data['yogi'] = $model->getWhere2('setting', $where); 

    // Pass data to the view
    echo view('header', $data);
    echo view('menu', $data);
    echo view('kelas_admin', [
        'all_classes' => $allClasses, 
        'yoga' => $filteredData
    ]);
    echo view('footer');

} else {
    return redirect()->to('home/login');
}
}
 public function edit_kelas($id)
    {

        if (session()->get('id') > 0) {
        $model = new M_projek();
        $where = ['id_kelas' => $id]; // Use the appropriate column name for filtering

        // Fetch the specific kelas object
        $data['dua'] = $model->getWhere1('kelas', $where); 
        $where = ['id_setting' => 1]; 
        $data['yogi'] = $model->getWhere2('setting', $where); 

        // Render views
        echo view('header', $data);
    echo view('menu', $data);
    echo view('e_kelas', $data);
    echo view('footer');
} else {
    return redirect()->to('home/login');
}
    }

    public function aksi_e_kelas(Request $request)
    {
        // Validasi input
        $request->validate([
            'namakelas' => 'required|string',
            'posisikelas' => 'required|string',
            'status' => 'required|string',
            'id' => 'required|integer',
        ]);
    
        // Ambil nilai dari request
        $nama_kelas = $request->input('namakelas'); // Gunakan input() untuk POST data
        $posisi_kelas = $request->input('posisikelas');
        $status = $request->input('status');
        $id = $request->input('id');
    
        // Where condition
        $where = array('id_kelas' => $id);
    
        // Data yang akan di-update
        $data = [
            'nama_kelas' => $nama_kelas,
            'posisi_kelas' => $posisi_kelas,
            'status' => $status,
        ];
    
        // Model untuk update
        $model = new M_projek();
        $model->edit('kelas', $data, $where); // Pastikan method edit sudah sesuai
    
        // Redirect ke halaman kelas dengan pesan sukses
        return redirect()->to('home/kelas_admin')->with('success', 'Kelas berhasil diubah!');
    }
    
    public function izin_kelas($id)
    {
        if (session()->get('id') > 0) {
        $model = new M_projek();
        $where = ['id_kelas' => $id]; // Use the appropriate column name for filtering

        // Fetch the specific kelas object
        $data['dua'] = $model->getWhere1('kelas', $where); 
        $where = ['id_setting' => 1]; 
        $data['yogi'] = $model->getWhere2('setting', $where); 

        // Render views
        echo view('header', $data);
    echo view('menu', $data);
    echo view('izin_kelas', $data);
    echo view('footer');
} else {
    return redirect()->to('home/login');
}
    }


    public function aksi_izin_kelas(Request $request)
    {
        // Validasi input
        $request->validate([
            'namakelas' => 'required|string',
            'posisikelas' => 'required|string',
            'sesi' => 'required|string',
            'keperluan' => 'required|string',
            'id' => 'required|integer',
        ]);
    
        // Ambil nilai dari request
        $nama_kelas = $request->input('namakelas'); // Gunakan input() untuk POST data
        $posisi_kelas = $request->input('posisikelas');
        $sesi = $request->input('sesi');
        $keperluan = $request->input('keperluan');
        $id = $request->input('id');
        $idPenanggung = session()->get('id'); 
        // Where condition
        $where = array('id_kelas' => $id);
    
        // Data yang akan di-update
        $data = [
            'nama_kelas' => $nama_kelas,
            'posisi_kelas' => $posisi_kelas,
            'sesi' => $sesi,
            'keperluan' => $keperluan,
            'status' => 'Pending',
            'id_penanggung' => $idPenanggung,
            'tanggal' => date('Y-m-d H:i:s'),
        ];
    
        // Model untuk update
        $model = new M_projek();
        $model->edit('kelas', $data, $where); // Pastikan method edit sudah sesuai
    
        // Redirect ke halaman kelas dengan pesan sukses
        return redirect()->to('home/kelas_admin')->with('success', 'Kelas berhasil diubah!');
    }

    public function aksi_izinkan_kelas(Request $request)
{
    // Validasi input
    $request->validate([
        'id_kelas' => 'required|integer', // Memastikan id_kelas adalah integer
    ]);

    // Ambil data id_kelas dari request
    $id_kelas = $request->input('id_kelas');
    
    // Update status kelas menjadi "Sedang di Pakai"
    $where = ['id_kelas' => $id_kelas];
    $data = ['status' => 'Sedang di Pakai'];

    // Model untuk update
    $model = new M_projek();
    $model->edit('kelas', $data, $where);

    // Redirect ke halaman kelas_admin
    return redirect()->to('home/kelas_admin')->with('success', 'Kelas berhasil diizinkan!');
}

public function aksi_selesai_kelas(Request $request)
{
    // Validasi input
    $request->validate([
        'id_kelas' => 'required|integer', // Memastikan id_kelas adalah integer
    ]);

    // Ambil data id_kelas dari request
    $id_kelas = $request->input('id_kelas');
    
    // Kondisi untuk update
    $where = ['id_kelas' => $id_kelas];

    // Data yang akan diupdate
    $data = [
        'id_penanggung' => null,  // Menghapus penanggung jawab
        'sesi' => null,           // Mengosongkan sesi
        'keperluan' => null,      // Mengosongkan keperluan
        'status' => 'Kosong'      // Mengubah status menjadi "Kosong"
    ];

    // Model untuk update
    $model = new M_projek();
    $model->edit('kelas', $data, $where);

    // Redirect ke halaman kelas_admin dengan pesan sukses
    return redirect()->to('home/kelas_admin')->with('success', 'Kelas berhasil diselesaikan!');
}


public function hapus_kelas($id)
{
    $model = new M_projek();
    $where = array('id_kelas' => $id);
    $array = array(
        'deleted_at' => date('Y-m-d H:i:s'),
    );
    $model->edit('kelas', $array, $where);
    // $this->logUserActivity('Menghapus Pemesanan');

    return redirect()->to('home/kelas_admin');
}
public function hapus_permanent($id)
{
    $model = new M_projek();
    // $this->logUserActivity('Menghapus Pemesanan Permanent');
    $where = array('id_kelas' => $id);
    $model->hapus('kelas', $where);

    return redirect()->to('home/kelas_admin');
}
public function restore()
{
    if (session()->get('id') > 0) {
    $model = new M_projek;
    $data['yoga'] = $model->tampilrestore('kelas');

    $where = ['id_setting' => 1]; 
    $data['yogi'] = $model->getWhere2('setting', $where); 
    echo view('header', $data);
    echo view('menu', $data);
    echo view('restore', $data);
    echo view('footer'); 
} else {
    return redirect()->to('home/login');
}
}

public function soft_delete($id)
    {
        $model = new M_projek();
        $where = array('id_kelas' => $id);
        $array = array(
            'deleted_at' => NULL, // Mengatur deleted_at menjadi null
        );
        $model->edit('kelas', $array, $where);
    
        return redirect()->to('home/kelas_admin');
    }


    public function kelas_akses()
        {
            if (session()->get('id') > 0) {
            $model = new M_projek();
            $data['kelas'] = $model->join1('kelas', 'user', 'kelas.id_user', 'user.id_user');


            
            $data['user'] = M_projek::tampil('user');

            $where = ['id_setting' => 1]; 
            $data['yogi'] = $model->getWhere2('setting', $where); 

            echo view('header', $data);
            echo view('menu', $data);
            echo view('kelas_akses', $data);
            echo view('footer'); 
        } else {
            return redirect()->to('home/login');
        }
        }

        public function aksi_set_admin(Request $request)
        {
            // Validasi input
            $request->validate([
                'id_kelas' => 'required|exists:kelas,id_kelas',
                'id_user' => 'required|exists:user,id_user',
            ]);
        
            // Ambil data dari request
            $id_kelas = $request->input('id_kelas');
            $id_user = $request->input('id_user');
        
            // Update kolom id_user di tabel kelas
            $model = new M_projek();
            $where = ['id_kelas' => $id_kelas];
            $data = ['id_user' => $id_user];
        
            $model->edit('kelas', $data, $where);
        
            // Redirect dengan pesan sukses
            return redirect()->to('home/kelas_akses')->with('success', 'Admin ruangan berhasil diatur.');
        }

        public function aksi_set_admin_null(Request $request)
        {
            $model = new M_projek();
            $id_kelas = $request->input('id_kelas'); // Mengambil data 'id_kelas' dari request POST
            $where = array('id_kelas' => $id_kelas);
        
            $array = array(
                'id_user' => null, // Menghapus admin ruangan dengan mengeset id_user menjadi null
            );
        
            $model->edit('kelas', $array, $where);
            
            return redirect()->to('home/kelas_akses');
        }
        public function setting()
        {
            if (session()->get('id') > 0) {
        
                $model = new M_projek();
                $where = ['id_setting' => 1]; 
                $data['yogi'] = $model->getWhere2('setting', $where); 
                
                echo view('header', $data);
                echo view('menu', $data);
                echo view('setting', $data);
                echo view('footer');
            }
        }
        
public function aksi_e_setting(Request $request)
{
    $model = new M_projek();
    // $this->logUserActivity('Melakukan Setting');

    // Use the $request parameter instead of $this->request
    $namaWebsite = $request->input('namawebsite');
    $id = $request->input('id');
    $id_user = session()->get('id');
    $where = array('id_setting' => '1');

    $data = array(
        'nama_website' => $namaWebsite,
        'update_by' => $id_user,
        'update_at' => now() // Use Laravel's now() helper
    );

    // Cek apakah ada file yang diupload untuk favicon
    $favicon = $request->file('img');
    if ($favicon && $favicon->isValid()) {
        // Generate a unique file name
        $faviconNewName = $favicon->getClientOriginalName(); // Or implement your preferred naming convention
        // Pindahkan file ke direktori public/images
        $favicon->move(public_path('images'), $faviconNewName);

        // Tambahkan nama file ke dalam array data
        $data['tab_icon'] = $faviconNewName;
    }

    // Cek apakah ada file yang diupload untuk logo
    $logo = $request->file('logo');
    if ($logo && $logo->isValid()) {
        // Generate a unique file name
        $logoNewName = $logo->getClientOriginalName(); // Or implement your preferred naming convention
        // Pindahkan file ke direktori public/images
        $logo->move(public_path('images'), $logoNewName);

        // Tambahkan nama file ke dalam array data
        $data['logo_website'] = $logoNewName;
    }

    // Cek apakah ada file yang diupload untuk login icon
    $login = $request->file('login');
    if ($login && $login->isValid()) {
        // Generate a unique file name
        $loginNewName = $login->getClientOriginalName(); // Or implement your preferred naming convention
        // Pindahkan file ke direktori public/images
        $login->move(public_path('images'), $loginNewName);

        // Tambahkan nama file ke dalam array data
        $data['login_icon'] = $loginNewName;
    }

    // Update the setting in the database
    $model->edit('setting', $data, $where);

    // Optionally set a flash message here
    return redirect()->to('home/setting');
}



}
        
