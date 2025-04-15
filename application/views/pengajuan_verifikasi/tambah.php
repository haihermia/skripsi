<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="<?= base_url('pengajuanverifikasi/ajukan'); ?>" method="POST" enctype="multipart/form-data">
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
                <!-- <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="Pending" <?= isset($pengajuan['status']) && $pengajuan['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Diterima" <?= isset($pengajuan['status']) && $pengajuan['status'] == 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
                        <option value="Ditolak" <?= isset($pengajuan['status']) && $pengajuan['status'] == 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                    </select>
                </div> -->
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

                <button type="submit" class="btn btn-primary">Ajukan</button>
                <a href="<?= base_url('pengajuanverifikasi'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->