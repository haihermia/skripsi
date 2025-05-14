<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $rekognisi['id']; ?>">

                <div class="form-group">
                    <label for="nama_rekognisi">Nama Rekognisi</label>
                    <input type="text" class="form-control" id="nama_rekognisi" name="nama_rekognisi" value="<?= $rekognisi['nama_rekognisi']; ?>">
                    <?= form_error('nama_rekognisi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="bidang_rekognisi">Bidang Rekognisi</label>
                    <input type="text" class="form-control" id="bidang_rekognisi" name="bidang_rekognisi" value="<?= $rekognisi['bidang_rekognisi']; ?>">
                    <?= form_error('bidang_rekognisi', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?= $rekognisi['nama_kegiatan']; ?>">
                </div>

                <div class="form-group">
                    <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                    <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" value="<?= $rekognisi['tanggal_kegiatan']; ?>">
                </div>

                <div class="form-group">
                    <label for="komponen_rekognisi">Komponen Rekognisi</label>
                    <select class="form-control" id="komponen_rekognisi" name="komponen_rekognisi" required>
                        <option value="">-- Pilih Komponen Rekognisi --</option>
                        <option value="pemakalah/speaker seminar" <?= ($rekognisi['komponen_rekognisi'] == 'pemakalah/speaker seminar') ? 'selected' : ''; ?>>Pemakalah/Speaker Seminar</option>
                        <option value="narasumber seminar" <?= ($rekognisi['komponen_rekognisi'] == 'narasumber seminar') ? 'selected' : ''; ?>>Narasumber Seminar</option>
                        <option value="peserta seminar" <?= ($rekognisi['komponen_rekognisi'] == 'peserta seminar') ? 'selected' : ''; ?>>Peserta Seminar</option>
                        <option value="msib (studi independent)" <?= ($rekognisi['komponen_rekognisi'] == 'msib (studi independent)') ? 'selected' : ''; ?>>MSIB (Studi Independent)</option>
                        <option value="msib (magang)" <?= ($rekognisi['komponen_rekognisi'] == 'msib (magang)') ? 'selected' : ''; ?>>MSIB (Magang)</option>
                        <option value="pmm (pertukaran mahasiswa merdeka)" <?= ($rekognisi['komponen_rekognisi'] == 'pmm (pertukaran mahasiswa merdeka)') ? 'selected' : ''; ?>>PMM (Pertukaran Mahasiswa Merdeka)</option>
                        <option value="membangun desa / kkn-t" <?= ($rekognisi['komponen_rekognisi'] == 'membangun desa / kkn-t') ? 'selected' : ''; ?>>Membangun Desa / KKN-T</option>
                        <option value="hki" <?= ($rekognisi['komponen_rekognisi'] == 'hki') ? 'selected' : ''; ?>>HKI</option>
                        <option value="publikasi jurnal sinta" <?= ($rekognisi['komponen_rekognisi'] == 'publikasi jurnal sinta') ? 'selected' : ''; ?>>Publikasi Jurnal Sinta</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="penyelenggara">Penyelenggara</label>
                    <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" value="<?= $rekognisi['penyelenggara']; ?>">
                </div>

                <div class="form-group">
                    <label for="bukti">Bukti</label><br>
                    <?php if (!empty($rekognisi['bukti'])): ?>
                        <?php
                        $file_ext = pathinfo($rekognisi['bukti'], PATHINFO_EXTENSION);
                        $file_url = base_url('uploads/bukti/' . $rekognisi['bukti']);
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
                <a href="<?= base_url('rekognisi'); ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->