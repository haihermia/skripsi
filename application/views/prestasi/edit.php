<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $prestasi['id']; ?>">

                <div class="form-group">
                    <label for="nama_prestasi">Nama Prestasi</label>
                    <input type="text" class="form-control" id="nama_prestasi" name="nama_prestasi" value="<?= $prestasi['nama_prestasi']; ?>">
                    <?= form_error('nama_prestasi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="bidang_prestasi">Bidang Prestasi</label>
                    <input type="text" class="form-control" id="bidang_prestasi" name="bidang_prestasi" value="<?= $prestasi['bidang_prestasi']; ?>">
                    <?= form_error('bidang_prestasi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?= $prestasi['nama_kegiatan']; ?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="<?= $prestasi['tanggal_kegiatan']; ?>">
                </div>

                <div class="form-group">
                    <label for="komponen_prestasi">Komponen Prestasi</label>
                    <select class="form-control" id="komponen_prestasi" name="komponen_prestasi" required>
                        <option value="">-- Pilih Komponen Prestasi --</option>
                        <option value="Juara Umum" <?= ($prestasi['komponen_prestasi'] == 'Juara Umum') ? 'selected' : ''; ?>>Juara Umum</option>
                        <option value="Juara 1 (Nasional)" <?= ($prestasi['komponen_prestasi'] == 'Juara 1 (Nasional)') ? 'selected' : ''; ?>>Juara 1 (Nasional)</option>
                        <option value="Juara 2 (Nasional)" <?= ($prestasi['komponen_prestasi'] == 'Juara 2 (Nasional)') ? 'selected' : ''; ?>>Juara 2 (Nasional)</option>
                        <option value="Juara 3 (Nasional)" <?= ($prestasi['komponen_prestasi'] == 'Juara 3 (Nasional)') ? 'selected' : ''; ?>>Juara 3 (Nasional)</option>
                        <option value="Juara Harapan 1 (Nasional)" <?= ($prestasi['komponen_prestasi'] == 'Juara Harapan 1 (Nasional)') ? 'selected' : ''; ?>>Juara Harapan 1 (Nasional)</option>
                        <option value="Juara Harapan 2 (Nasional)" <?= ($prestasi['komponen_prestasi'] == 'Juara Harapan 2 (Nasional)') ? 'selected' : ''; ?>>Juara Harapan 2 (Nasional)</option>
                        <option value="Juara Harapan 3 (Nasional)" <?= ($prestasi['komponen_prestasi'] == 'Juara Harapan 3 (Nasional)') ? 'selected' : ''; ?>>Juara Harapan 3 (Nasional)</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="penyelenggara">Penyelenggara</label>
                    <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" value="<?= $prestasi['penyelenggara']; ?>">
                </div>

                <div class="form-group">
                    <label for="bukti">Bukti</label><br>
                    <?php if (!empty($prestasi['bukti'])): ?>
                        <?php
                        $file_ext = pathinfo($prestasi['bukti'], PATHINFO_EXTENSION);
                        $file_url = base_url('uploads/bukti/' . $prestasi['bukti']);
                        $is_image = in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'webp']);
                        ?>
                        <p>File Saat Ini:</p>
                        <?php if ($is_image): ?>
                            <img src="<?= $file_url ?>" alt="Bukti" style="max-width: 300px; height: auto; border: 1px solid #ccc; padding: 5px; margin-bottom: 10px;">
                        <?php elseif (strtolower($file_ext) === 'pdf'): ?>
                            <embed src="<?= $file_url ?>" type="application/pdf" width="100%" height="500px" />
                        <?php else: ?>
                            <a href="<?= $file_url ?>" target="_blank">Lihat Bukti</a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <input type="file" name="bukti" id="bukti" class="form-control-file mt-2">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti bukti.</small>
                </div>


                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?= base_url('prestasi'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->