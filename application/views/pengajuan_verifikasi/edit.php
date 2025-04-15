<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="<?= base_url('pengajuanverifikasi/update/' . $pengajuan['id']); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $pengajuan['nama']; ?>" required disabled>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $pengajuan['email']; ?>" required disabled>
                </div>
                <div class="form-group">
                    <label for="jenis_pengajuan">Jenis Pengajuan</label>
                    <select class="form-control" id="jenis_pengajuan" name="jenis_pengajuan" required disabled>
                        <option <?= $pengajuan['jenis_pengajuan']== 'data prestasi'? 'selected':''  ;?> value="data prestasi">Data Prestasi</option>
                        <option <?= $pengajuan['jenis_pengajuan']== 'data rekognisi'? 'selected':''  ;?> value="data rekognisi">Data Rekognisi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dokumen">Dokumen</label>
                    <img class="img-fluid" src="<?= base_url('uploads/bukti/' . $pengajuan['dokumen']); ?>">
                    <?php if (!empty($pengajuan['dokumen'])): ?>
                        <small class="text-muted">File saat ini: <a href="<?= base_url('uploads/bukti/' . $pengajuan['dokumen']); ?>" target="_blank"><?= $pengajuan['dokumen']; ?></a></small>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="tanggal_pengajuan">Tanggal Pengajuan</label>
                    <input type="date" class="form-control" id="tanggal_pengajuan" name="tanggal_pengajuan" value="<?= $pengajuan['tanggal_pengajuan']; ?>" required>
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

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('pengajuanverifikasi'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->