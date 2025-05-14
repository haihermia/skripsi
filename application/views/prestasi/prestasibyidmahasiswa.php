<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Notifikasi (jika ada) -->
    <?= $this->session->flashdata('message'); ?>
            
            <!-- Menampilkan error validasi form -->
            <?php if(validation_errors()): ?>
                <div class="alert alert-danger">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Tombol Tambah Data -->
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahPrestasiModal">
                Tambah Data Prestasi
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Prestasi</th>
                            <th>Bidang Prestasi</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Komponen Prestasi</th>
                            <th>Penyelenggara</th>
                            <th>Bukti</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($prestasi as $p) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $p['nim']; ?></td>
                                <td><?= $p['nama_prestasi']; ?></td>
                                <td><?= $p['bidang_prestasi']; ?></td>
                                <td><?= $p['nama_kegiatan']; ?></td>
                                <td><?= date('d-m-Y', strtotime($p['tanggal_kegiatan'])); ?></td>
                                <td><?= $p['komponen_prestasi']; ?></td>
                                <td><?= $p['penyelenggara']; ?></td>
                                <td><a href="<?= base_url() . 'uploads/bukti/' . $p['bukti']; ?>">Lihat</a></td>

                                <td style="white-space: nowrap; text-align: center;">
                                    <div class="btn-group">
                                        <a href="<?= base_url('prestasi/editPrestasi/') . $p['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= base_url('prestasi/hapusPrestasi/') . $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahPrestasiModal" tabindex="-1" aria-labelledby="tambahPrestasiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPrestasiLabel">Tambah Data Prestasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('prestasi/tambah'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="number" class="form-control" id="nim" name="nim" required disabled value="<?= $mahasiswa['nim'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama_prestasi">Nama Prestasi</label>
                        <input type="text" class="form-control" id="nama_prestasi" name="nama_prestasi" required>
                    </div>
                    <div class="form-group">
                        <label for="bidang_prestasi">Bidang Prestasi</label>
                        <input type="text" class="form-control" id="bidang_prestasi" name="bidang_prestasi" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="komponen_prestasi">Komponen Prestasi</label>
                        <select class="form-control" id="komponen_prestasi" name="komponen_prestasi" required>
                            <option value="">-- Pilih Komponen Prestasi --</option>
                            <option value="Juara Umum">Juara Umum</option>
                            <option value="Juara 1 (Nasional)">Juara 1 (Nasional)</option>
                            <option value="Juara 2 (Nasional)">Juara 2 (Nasional)</option>
                            <option value="Juara 3 (Nasional)">Juara 3 (Nasional)</option>
                            <option value="Juara Harapan 1 (Nasional)">Juara Harapan 1 (Nasional)</option>
                            <option value="Juara Harapan 2 (Nasional)">Juara Harapan 2 (Nasional)</option>
                            <option value="Juara Harapan 3 (Nasional)">Juara Harapan 3 (Nasional)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="penyelenggara">Penyelenggara</label>
                        <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" required>
                    </div>
                    <div class="form-group">
                        <label for="bukti">Bukti (URL/File)</label>
                        <input type="file" class="form-control" id="bukti" name="bukti" required>
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