
<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori Barang</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>
    <form method="post" action="{{ url('/user/tambah_simpan') }}">
        {{ csrf_field() }}
      
      <label>Username</label>
      <input type="text" name="username" placeholder="Masukan Username">
      <br>
      
      <label>Nama</label>
      <input type="text" name="nama" placeholder="Masukan Nama">
      <br>
      
      <label>Password</label>
      <input type="password" name="password" placeholder="Masukan Password">
      <br>
      
      <label>Level ID</label>
      <input type="number" name="level_id" placeholder="Masukan ID Level">
      <br><br>
      
      <input type="submit" class="btn btn-success" value="Simpan">
    </form>
  </body>
  

</html>
