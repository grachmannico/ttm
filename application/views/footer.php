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
<!-- <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script> -->
<script src="<?php echo base_url() . "assets/"; ?>ckeditor/ckeditor.js"></script>
<!-- InputMask -->
<!-- <script src="<?php echo base_url() . "assets/"; ?>mask/src/jquery.mask.js"></script> -->
<script src="<?php echo base_url() . "assets/"; ?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url() . "assets/"; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url() . "assets/"; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $("#example2").DataTable();
    $("#example3").DataTable();
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false
    // });
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    $("#datemask2").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    $("#money").inputmask("999.999.999", { numericInput: true });
    $("#qty").inputmask("999.999.999", { numericInput: true });
    $("[data-mask]").inputmask();
    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
    CKEDITOR.config.autoParagraph = false;
    CKEDITOR.replace('editor1');
  });
</script>

<!-- disable f5 refresh -->
<script type="text/javascript">
  document.onkeydown = function (e) {
  if (e.keyCode === 116) {
      return false;
    }
  };
</script>

<!-- disable back button -->
<script type="text/javascript">
  history.pushState(null, null, document.URL);
  window.addEventListener('popstate', function () {
      history.pushState(null, null, document.URL);
  });
</script>

<!-- confirm deletion -->
<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Yakin Ingin Menghapus Data Ini?');
}
</script>

<!-- confirm transaction -->
<script language="JavaScript" type="text/javascript">
function isValid(){
    return confirm('Yakin Transaksi Ini Valid?');
}
</script>
<script language="JavaScript" type="text/javascript">
function isNotValid(){
    return confirm('Yakin Transaksi Ini Tidak Valid?');
}
</script>

<!-- image upload validation -->
<script type="text/javascript">
  var _validFileExtensions = [".jpg", ".gif", ".png"];    
  function Validate(oForm) {
      var arrInputs = oForm.getElementsByTagName("input");

      for (var i = 0; i < arrInputs.length; i++) {
          var oInput = arrInputs[i];
          if (oInput.type == "file") {
              var sFileName = oInput.value;
              if (sFileName.length > 0) {
                  var blnValid = false;
                  for (var j = 0; j < _validFileExtensions.length; j++) {
                      var sCurExtension = _validFileExtensions[j];
                      if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                          blnValid = true;
                          break;
                      }
                  }
                  
                  if (!blnValid) {
                      // alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                      alert("Sorry, your file is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                      return false;
                  }
              }
          }
      }    
      return true;
  }
</script>

<!-- CKEditor -->
<script type="text/javascript">
  function check_form() {
    var editor_val = CKEDITOR.instances.editor1.document.getBody().getChild(0).getText() ;
      
    if (editor_val == '') {
      alert('Please fill out Editor field.') ;
      return false ;
    }
      
    return true ;
  }
</script>

<!-- <script type="text/javascript">
  $(document).ready(function(){
    $('#money').mask('000.000.000.000.000', {reverse: true});
  });
</script> -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>