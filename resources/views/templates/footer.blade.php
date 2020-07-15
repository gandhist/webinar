<!-- jQuery 2.2.3 -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/iCheck/icheck.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/fastclick/fastclick.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-2.3.11/dist/js/app.min.js') }}"></script>

<script src="{{ asset('js/moment.js') }}" defer></script>
<!-- global custom js -->
<script type="text/javascript" src="{{ asset('global.js') }}"></script>

<!-- Data Table -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

{{-- Datatable export button --}}
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>



<!-- File input bootstrap -->
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/plugins/piexif.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/plugins/sortable.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/plugins/purify.min.js') }}"></script>
<script src="{{ asset('AdminLTE-2.3.11/plugins/fileinput-v4.5.2-0/js/fileinput.min.js') }}"></script>

<script src="{{ asset('AdminLTE-2.3.11/plugins/jquery-validation-1.19.0/dist/jquery.validate.min.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        /** add active class and stay opened when selected */
        var host = window.location.origin;
        var single_sub = window.location;
        var link = window.location.pathname;
        var url = link.slice(0, link.lastIndexOf('/'));
        // for sidebar menu entirely but not cover treeview
        var a = url.split('/');
        if ($.isNumeric([2])) {
            var last = a[2].replace(/\d+/, '');
            var numberic_url = host + '/' + a[1]
        } else {
            var numberic_url = host + '/' + a[1] + '/' + a[2];
        }
        //console.log(a[2]);
        $('ul.sidebar-menu a').filter(function() {
            return this.href == host + url || this.href == single_sub || this.href == numberic_url;
        }).parent().addClass('active');

        // for treeview
        $('ul.treeview-menu a').filter(function() {
            return this.href == host + url || this.href == single_sub || this.href == numberic_url;
        }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');
    });


</script>
{{-- my style  --}}
@stack('script')
</body>

</html>