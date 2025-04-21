<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Daftar Mahasiswa</h1>

    <!-- Notifikasi (jika ada) -->
    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Tombol Tambah Data -->
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahMahasiswaModal">
                Tambah Mahasiswa
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Fakultas</th>
                            <th>Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($mahasiswa)) : ?>
                            <?php $no = 1; ?>
                            <?php foreach ($mahasiswa as $m) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $m['nim']; ?></td>
                                    <td><?= $m['nama_mahasiswa']; ?></td>
                                    <td><?= $m['email']; ?></td>
                                    <td><?= $m['fakultas']; ?></td>
                                    <td><?= $m['program_studi']; ?></td>
                                    <td>
                                        <a href="<?= base_url('mahasiswa/edit/') . $m['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= base_url('mahasiswa/hapus/') . $m['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data mahasiswa.</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Mahasiswa -->
<div class="modal fade" id="tambahMahasiswaModal" tabindex="-1" aria-labelledby="tambahMahasiswaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMahasiswaLabel">Tambah Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('mahasiswa/tambah'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="number" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Fakultas</label>
                        <input type="text" class="form-control" id="fakultas" name="fakultas" required>
                    </div>
                    <div class="form-group">
                        <label for="program_studi">Prodi</label>
                        <input type="text" class="form-control" id="program_studi" name="program_studi" required>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user"
                                id="password1" name="password1" placeholder="Password">
                            <?= form_error('password1', '<small class="text-danger" pl-3>', '</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user"
                                id="password2" name="password2" placeholder="Repeat Password">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>