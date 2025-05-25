<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Notifikasi (jika ada) -->
    <?= $this->session->flashdata('message'); ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- Tombol Tambah Data -->
            <?php if ($this->session->userdata('role_id') == 2): ?>
                <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#tambahPengajuanModal">
                    Tambah Pengajuan Verifikasi
                </button>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jenis Pengajuan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Catatan</th>
                            <th>Tanggal Verifikasi</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengajuan)) : ?>
                            <?php $no = 1; ?>
                            <?php foreach ($pengajuan as $p) : ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $p['nama_prestasi']; ?></td>
                                    <td><?= $p['nim']; ?></td>
                                    <td>
                                        <?php if ($p['jenis'] == 'prestasi'): ?>
                                            <span class="badge badge-primary">Prestasi</span>
                                        <?php elseif ($p['jenis'] == 'rekognisi'): ?>
                                            <span class="badge badge-success">Rekognisi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><a href="<?= base_url() . 'uploads/bukti/' . $p['bukti']; ?>">Lihat</a></td>
                                    <td>
                                        <?php if ($p['status'] == 'diajukan'): ?>
                                            <span class="badge badge-warning">Diajukan</span>
                                        <?php elseif ($p['status'] == 'diterima'): ?>
                                            <span class="badge badge-success">Diterima</span>
                                        <?php elseif ($p['status'] == 'ditolak'): ?>
                                            <span class="badge badge-danger">Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><?= $p['status']; ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $p['tanggal']; ?></td>
                                    <td>
                                        <?php if (!empty($p['catatan'])): ?>
                                            <?= $p['catatan']; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Belum diverifikasi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($p['tanggal_verifikasi'])): ?>
                                            <?= date('d-m-Y', strtotime($p['tanggal_verifikasi'])); ?>
                                        <?php else: ?>
                                            <span class="text-muted">Belum diverifikasi</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- <td style="white-space: nowrap; text-align: center;">
                                        <div class="btn-group">
                                            <?php if ($p['status'] == 'diterima' || $p['status'] == 'ditolak'): ?>
                                                <button class="btn btn-sm btn-primary"
                                                    <?= ($p['status'] == 'pending') ? '' : 'disabled'; ?>>
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            <?php elseif ($p['status'] == 'pending'): ?>
                                                <a href="<?= base_url('pengajuanverifikasi/edit/') . $p['id']; ?>" class="btn btn-sm btn-primary" <?= ($p['status'] == 'pending') ? '' : 'disabled'; ?>>
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            <?php endif ?>

                                            <?php if ($p['status'] == 'diterima' || $p['status'] == 'ditolak'): ?>
                                                <button class="btn btn-sm btn-danger"
                                                    <?= ($p['status'] == 'pending') ? '' : 'disabled'; ?>>
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>

                                            <?php elseif ($p['status'] == 'pending'): ?>
                                                <a href="<?= base_url('pengajuanverifikasi/hapus/') . $p['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?');">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            <?php endif ?>
                                        </div>

                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9" class="text-center">Belum ada pengajuan verifikasi.</td>
                            </tr>
                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahPengajuanModal" tabindex="-1" aria-labelledby="tambahPengajuanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPengajuanLabel">Tambah Pengajuan Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('pengajuanverifikasi/ajukan'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pengajuan">Jenis Pengajuan</label>
                        <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan" required>
                            <option value="">-- Pilih Jenis Pengajuan --</option>
                            <option value="data prestasi">Data Prestasi</option>
                            <option value="data rekognisi">Data Rekognisi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dokumen">Dokumen</label>
                        <input type="file" class="form-control" id="dokumen" name="dokumen" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                        <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan" required>
                    </div>
                    <?php if ($this->session->userdata('role_id') == 4 || $this->session->userdata('role_id') == 5): ?>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="Pending">Pending</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_verifikasi">Tanggal Verifikasi</label>
                            <input type="date" class="form-control" id="tanggal_verifikasi" name="tanggal_verifikasi">
                        </div>
                    <?php endif; ?>
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