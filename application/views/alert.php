  <div class="content-wrapper">
    <section class="content-header">
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box-body">
              <div class="alert alert-danger alert-dismissible">
                <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
                <?php echo $alert['pesan'] ?><br><br>
                <form action="<?php echo base_url(); ?><?php echo $alert['url_target']; ?>" method="POST">
                  <button type="subimt" class="btn btn-default" name="<?php echo $alert['name'] ?>" value="<?php echo $alert['value']; ?>">Kembali</button>
                </form>
              </div>
            </div>
        </div>
      </div>
    </section>
  </div>