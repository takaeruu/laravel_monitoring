<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB; // Pastikan untuk mengimpor ini
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class M_projek extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'user'; // Nama tabel
    protected $primaryKey = 'id_user'; // Primary key jika berbeda dari default 'id'

    public static function getWhere($table, $where)
{
    return DB::table($table)
        ->where($where) // Menggunakan where sebagai array
        ->first(); // Mengambil satu data berdasarkan kondisi
}
public static function getWhere1($table, $where)
{
    return DB::table($table)->where($where)->first(); // Menggunakan first() untuk mengembalikan satu objek
}
public function getWhere2($table, $where)
{
    return DB::table($table)->where($where)->first(); // Fetch the first matching record
}

public function tampilrestore($tableName)
{
    return DB::table($tableName)
        ->whereNotNull('deleted_at') // Menggunakan whereNotNull untuk memeriksa deleted_at
        ->get(); // Mengambil semua hasil
}
public function saveToBackup($table, $data)
{
    return DB::table($table)->insert($data); // Use Query Builder to insert data
}

public function edit($table, $data, $conditions)
{
    return DB::table($table)
        ->where($conditions) // Menentukan kondisi untuk update
        ->update($data); // Melakukan update data
}
public function hapus($table, $where)
{
    // Menggunakan DB::table() untuk menghapus data
    return DB::table($table)->where($where)->delete();
}
public function join1($tabel1, $tabel2, $onColumn1, $onColumn2)
{
    return DB::table($tabel1)
        ->leftJoin($tabel2, $onColumn1, '=', $onColumn2) // Left Join antara kelas dan user
        ->get();
}
public function getById($id)
{
    return DB::table('user')
        ->where('id_user', $id)
        ->first(); // Mengembalikan satu baris data sebagai objek
}







    public static function tampil($tableName)
    {
        return DB::table($tableName)->get(); // Menggunakan Query Builder untuk mengambil semua data dari tabel yang diberikan
    }
    public function tambah($table, $data)
    {
        return DB::table($table)->insert($data); // Using Query Builder for insertion
    }

    public function tampilWhere($table, $whereCondition)
    {
        return DB::table($table)
            ->where($whereCondition)
            ->whereNull('deleted_at') // Assuming you have soft deletes
            ->get();
    }

    // Join function to get kelas with user data
    public function joinKelasWithUser($where)
    {
        return DB::table('kelas')
            ->select('kelas.*', 'user.*', 'kelas.status as kelasstatus')
            ->join('user', 'kelas.id_penanggung', '=', 'user.id_user')
            ->where($where)
            ->get();
    }

    public function countKelasKosong()
{
    return DB::table('kelas')->where('status', 'Kosong')->count();
}
public function countKelasPenuh()
{
    return DB::table('kelas')->where('status', 'Kelas di Pakai')->count();
}
public function countKelas()
{
    return DB::table('kelas')->count(); // Counts all entries in the 'kelas' table
}

public function resetPassword($id)
{
    // Find the user by ID
    $user = self::find($id);

    // Check if user exists
    if (!$user) {
        return false; // or throw an exception if preferred
    }

    // Set password to '1' and hash it
    $user->password = Hash::make('1'); // Use Laravel's Hash facade
    return $user->save(); // Save the changes to the database
}
}
