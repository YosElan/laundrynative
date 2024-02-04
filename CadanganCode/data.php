<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika pengguna belum login, arahkan ke halaman login.php
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
include 'nav.php';
?>


  
  <!-- Main Content Area -->
  <div class="container mt-5 content-container">
    <h2 class="text-center">Selamat datang, berikut data Outlet</h2>
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahDataModal">
        Tambah Data
      </button>
    </div>

    <table class="table mt-4">
      <thead class="table-info">
        <tr>
          <th scope="col">No</th>
          <th scope="col">ID Outlet</th>
          <th scope="col">Nama Outlet</th>
          <th scope="col">Alamat Outlet</th>
          <th scope="col">Telepon</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $hasil = $koneksi->query("SELECT * FROM outlet");
        while ($row = $hasil->fetch_assoc()) {
        ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $row['id_outlet']; ?></td>
          <td><?= $row['nama_outlet']; ?></td>
          <td><?= $row['alamat_outlet']; ?></td>
          <td><?= $row['telp_outlet']; ?></td>
          <td>
            <!-- Tombol Edit Data -->
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
              data-bs-target="#editModal<?= $row['id_outlet']; ?>">
              Edit
            </button>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal<?= $row['id_outlet']; ?>" tabindex="-1" aria-labelledby="editModal<?= $row['id_outlet']; ?>" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $row['id_outlet']; ?>">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <!-- Form edit data -->
                    <form method="POST">
                      <input type="hidden" name="id_outlet" value="<?= $row['id_outlet']; ?>">
                      <div class="mb-3">
                        <label for="nama_outlet" class="form-label">Nama Outlet</label>
                        <input type="text" name="nama_outlet" class="form-control" id="nama_outlet" value="<?= $row['nama_outlet']; ?>" required>
                      </div>
                      <div class="mb-3">
                          <label for="alamat_outlet" class="form-label">Alamat Outlet</label>
                          <textarea name="alamat_outlet" class="form-control" id="alamat_outlet" required><?= $row['alamat_outlet']; ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label for="telp_outlet" class="form-label">Telepon</label>
                        <input type="number" name="telp_outlet" class="form-control" id="telp_outlet" value="<?= $row['telp_outlet']; ?>" required>
                      </div>
                      <button type="submit" name="edit_outlet" class="btn btn-primary" value="edit">Edit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tombol Hapus Data -->
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
              data-bs-target="#hapusModal<?= $row['id_outlet']; ?>">
              Hapus
            </button>

            <!-- Modal Hapus -->
            <div class="modal fade" id="hapusModal<?= $row['id_outlet']; ?>" tabindex="-1" aria-labelledby="hapusModalLabel<?= $row['id_outlet']; ?>" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="hapusModalLabel<?= $row['id_outlet']; ?>">Konfirmasi Hapus</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <p>Anda yakin ingin menghapus data ini?</p>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                          <a href="koneksi.php?id_outlet=<?= $row['id_outlet']; ?>" class="btn btn-danger">Hapus</a>
                      </div>
                  </div>
              </div>
          </div>
          </td>
        </tr>
        <?php } ?>
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
              <label for="id_outlet" class="form-label">ID Outlet</label>
              <input type="number" name="id_outlet" class="form-control" id="id_outlet" required>
            </div>
            <div class="mb-3">
              <label for="nama_outlet" class="form-label">Nama Outlet</label>
              <input type="text" name="nama_outlet" class="form-control" id="nama_outlet" required>
            </div>
            <div class="mb-3">
              <label for="alamat_outlet" class="form-label">Alamat Outlet</label>
              <textarea name="alamat_outlet" class="form-control" id="alamat_outlet" required></textarea>
            </div>
            <div class="mb-3">
              <label for="telp_outlet" class="form-label">Telepon Outlet</label>
              <input type="number" name="telp_outlet" class="form-control" id="telp_outlet" required>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
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
</html>
