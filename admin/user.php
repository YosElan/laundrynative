<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika pengguna belum login, arahkan ke halaman login.php
    header("Location: ../login.php");
    exit;
}

include 'koneksi.php';
include 'nav.php';
?>

<div class="container mt-5 content-container">
    <h2 class="text-center">Selamat datang, berikut data User</h2>
    <div class="d-flex justify-content-end mb-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
            Tambah Data
        </button>
    </div>

    <table class="table mt-4">
        <thead class="table-info">
            <tr>
                <th scope="col">No</th>
                <th scope="col">ID User</th>
                <th scope="col">Nama User</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Nama Outlet</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $hasil = $koneksi->query("SELECT users.*, outlet.nama_outlet FROM users 
            JOIN outlet ON users.outlet_id = outlet.id_outlet");

            while ($row = $hasil->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_user']; ?></td>
                    <td><?= $row['nama_user']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['password']; ?></td>
                    <td><?= $row['nama_outlet']; ?></td>
                    <td><?= $row['role']; ?></td>
                    <td>
                        <!-- Tombol Edit Data -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#editModal<?= $row['id_user']; ?>" <?= ($row['id_user'] == 1) ? 'disabled' : ''; ?>>
                            Edit
                        </button>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?= $row['id_user']; ?>" tabindex="-1" aria-labelledby="editModal<?= $row['id_user']; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel<?= $row['id_user']; ?>">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form edit data -->
                        <form method="POST">
            <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
            <div class="mb-3">
                <label for="nama_user" class="form-label">Nama User</label>
                <input type="text" name="nama_user" class="form-control" id="nama_user" value="<?= $row['nama_user']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="<?= $row['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Leave blank to keep current password" required>
            </div>
            <div class="mb-3">
                <label for="outlet_id" class="form-label">Nama Outlet</label>
                <select name="outlet_id" class="form-control" id="outlet_id" required>
                    <?php
                    // Ambil data outlet dari database
                    $hasil_outlet = $koneksi->query("SELECT * FROM outlet");

                    // Tampilkan opsi untuk setiap outlet
                    while ($row_outlet = $hasil_outlet->fetch_assoc()) {
                        $selected = ($row_outlet['id_outlet'] == $row['outlet_id']) ? 'selected' : '';
                        echo '<option value="' . $row_outlet['id_outlet'] . '" ' . $selected . '>' . $row_outlet['nama_outlet'] . '</option>';
                    }
                    ?>
                </select>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select name="role" class="form-control" id="role" required>
            <option value="admin" <?php echo (isset($row['role']) && $row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="kasir" <?php echo (isset($row['role']) && $row['role'] == 'kasir') ? 'selected' : ''; ?>>Kasir</option>
        </select>
    </div>
    <button type="submit" name="edit_user" class="btn btn-primary" value="edit">Edit</button>
</form>

            </div>
        </div>
    </div>
</div>

                    </div>

                    <!-- Tombol Hapus Data -->
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#hapusModal<?= $row['id_user']; ?>" <?= ($row['id_user'] == 1) ? 'disabled' : ''; ?>>
                        Hapus
                    </button>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="hapusModal<?= $row['id_user']; ?>" tabindex="-1"
                        aria-labelledby="hapusModalLabel<?= $row['id_user']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="hapusModalLabel<?= $row['id_user']; ?>">Konfirmasi
                                        Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Anda yakin ingin menghapus data ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                    </button>
                                    <a href="koneksi.php?id_user=<?= $row['id_user']; ?>"
                                        class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

  </div>

  <!-- Modal Tambah Data -->
  <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahDataModalLabel">Tambah Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
    <!-- Form tambah data -->
    <form method="POST" action="koneksi.php">
        <div class="mb-3">
            <label for="id_user" class="form-label">ID User</label>
            <input type="number" name="id_user" class="form-control" id="id_user" required>
        </div>
        <div class="mb-3">
                    <label for="nama_user" class="form-label">Nama User</label>
                    <input type="text" name="nama_user" class="form-control" id="nama_user">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password"    required>
                </div>
                <div class="mb-3">
                  <label for="outlet_id" class="form-label">Nama Outlet</label>
                  <select name="outlet_id" class="form-control" id="outlet_id" required>
                      <?php
                      // Ambil data outlet dari database
                      $hasil_outlet = $koneksi->query("SELECT * FROM outlet");

                      // Tampilkan opsi untuk setiap outlet
                      while ($row_outlet = $hasil_outlet->fetch_assoc()) {
                        $selected = ($row_outlet['id_outlet'] == $row['outlet_id']) ? 'selected' : '';
                        echo '<option value="' . $row_outlet['id_outlet'] . '" ' . $selected . '>' . $row_outlet['nama_outlet'] . '</option>';
                      }
                      ?>
                  </select>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" class="form-control" id="role" required>
                    <option value="admin" <?php echo (isset($row['role']) && $row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="kasir" <?php echo (isset($row['role']) && $row['role'] == 'kasir') ? 'selected' : ''; ?>>Kasir</option>
                    <!-- <option value="owner" <?php //echo (isset($row['role']) && $row['role'] == 'owner') ? 'selected' : ''; ?>>owner</option> -->
                    </select>
                </div>
        <button type="submit" name="simpan_user" class="btn btn-primary">Simpan</button>
    </form>
</div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var nav = document.querySelector('nav');

    window.addEventListener('scroll', function () {
      if (window.pageYOffset > 100) {
        nav.classList.add('bg-dark', 'shadow');
      } else {
        nav.classList.remove('bg-dark', 'shadow');
      }
    });
  </script>
</body>