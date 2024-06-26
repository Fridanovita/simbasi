<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Edit Detail Barang
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barang/detail') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('', [], ['stok' => 0, 'id_detail' => $detail_barang['id_detail']]); ?>
                <div class="row form-group">
                    <input type="hidden" name="id_detail" value="<?= $detail_barang['id_detail']; ?>">
                    <label class="col-md-4 text-md-right" for="serial_number">SN</label>
                    <div class="col-md-8">
                        <input value="<?= set_value('serial_number', $detail_barang['serial_number']); ?>" name="serial_number" id="serial_number" type="text" class="form-control" placeholder="SN...">
                        <?= form_error('serial_number', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="merk">Merk</label>
                    <div class="col-md-8">
                        <input value="<?= set_value('merk', $detail_barang['merk']); ?>" name="merk" id="merk" type="text" class="form-control" placeholder="Merk...">
                        <?= form_error('merk', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tipe">Tipe</label>
                    <div class="col-md-8">
                        <input value="<?= set_value('tipe', $detail_barang['tipe']); ?>" name="tipe" id="tipe" type="text" class="form-control" placeholder="Tipe...">
                        <?= form_error('tipe', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="kondisi">Kondisi</label>
                    <div class="col-md-8">
                        <input value="<?= set_value('kondisi', $detail_barang['kondisi']); ?>" name="kondisi" id="kondisi" type="text" class="form-control" placeholder="Kondisi...">
                        <?= form_error('kondisi', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">    
                    <label class="col-md-4 text-md-right" for="location">Lokasi</label>
                    <div class="col-md-8">
                        <input value="<?= set_value('location', $detail_barang['location']); ?>" name="location" id="location" type="text" class="form-control" placeholder="Lokasi...">
                        <?= form_error('location', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div> 
                <div class="row form-group">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
