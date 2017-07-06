  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      website gua udah siap yooooooo
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017 <a href="#">Turun Tangan Malang</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery map -->
<script src="<?php echo base_url() . "assets/"; ?>map/jquery.js"></script>
<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url() . "assets/"; ?>bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() . "assets/"; ?>dist/js/app.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() . "assets/"; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/fastclick/fastclick.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url() . "assets/"; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url() . "assets/"; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    CKEDITOR.replace('editor1');
  });
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>