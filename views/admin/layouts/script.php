<script src="/assets/admin/js/jquery-1.6.4.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/admin/js/jquery-ui/jquery.ui.core.min.js"></script>
<script src="/assets/admin/js/jquery-ui/jquery.ui.widget.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery-ui/jquery.ui.accordion.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery-ui/jquery.effects.core.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery-ui/jquery.effects.slide.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery-ui/jquery.ui.mouse.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/jquery-ui/jquery.ui.sortable.min.js" type="text/javascript"></script>
<script src="/assets/admin/js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- END: load jquery -->
<script type="text/javascript" src="/assets/admin/js/table/table.js"></script>
<script src="/assets/admin/js/setup.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        setSidebarHeight();
    });
    $.ajaxSetup({
        dataFilter: function(data){
            try {
                jsonParseData = JSON.parse(data);
                return jsonParseData;
            } catch (e) {
                return data;
            }
        }
    });

    function initDatepicker(picker){

        picker.datepicker({
            todayHighlight: !0,
            format        : 'dd-mm-yyyy',
            autoclose     : true,
        });

        return picker;
    }

    function initImageFile(image, inputFile){

        image.click(function(){
            inputFile.trigger('click');
        });

        inputFile.change(function(){
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = image[0];
                img.src = e.target.result;
            };
            reader.readAsDataURL(inputFile[0].files[0]);
        });

    }

    function initDatatable(tableElement, showAll=false, config={}){ // table jquery element

        var datatableConfig = {
            bSort: false,
            responsive: !0,
            language  : {
                'sProcessing'  : '??ang x??? l??',
                'sLengthMenu'  : 'Xem _MENU_b???n ghi',
                'sZeroRecords' : 'Kh??ng t??m th???y d??ng n??o ph?? h???p',
                'sInfo'        : '??ang xem _START_ ?????n _END_ trong t???ng s??? _TOTAL_ b???n ghi',
                'sInfoEmpty'   : '??ang xem 0 ?????n 0 trong t???ng s??? 0 b???n ghi',
                'sInfoFiltered': '(???????c l???c t??? _MAX_ b???n ghi)',
                'sInfoPostFix' : '',
                'sSearch'      : 'T??m ki???m',
                'sUrl'         : '',
                'oPaginate'    : {
                    'sFirst'       : '?????u',
                    'sPrevious': 'Tr?????c',
                    'sNext'    : 'Ti???p',
                    'sLast'    : 'Cu???i',

                },
                'select': {
                    rows: {
                        _: '???? ch???n %d b???n ghi',
                        1: '???? ch???n 1 b???n ghi',
                    },
                },
            },

            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, 'All'],
            ],

            iDisplayLength: 2,
        };

        Object.assign(datatableConfig,config);
        var table = $('#list-users').DataTable(datatableConfig);


        // init mark index for rows
        table.on('order.dt search.dt', function () {
            table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // init search in collumn table
        table.columns().every(function () {
            var that = this;

            $('input', this.header()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });

        if(showAll){
            showAllRowsDatatable(table)
        }

        return table;
    }

    function showAllRowsDatatable(table){ // datatable element
        var setting                    = table.settings();
        setting[0]._iDisplayLength = setting[0].fnRecordsTotal();
        table.draw();
    }

    function alert(message, type='info', detail=''){
        Swal.fire(
            message,
            detail,
            type
        );
    }

    function confirm(title, runFunction, dismissFunction, type, text) {

        var type = type == undefined ? 'warning' : type;

        var dismissFunction = dismissFunction === undefined ?
            function () {
                return false;
            }
            : dismissFunction;

        Swal.fire({
            title: title,
            text: text,
            icon: type,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'C??',
            cancelButtonText: 'Kh??ng'
        }).then(function (e) {
            e.value ?
                runFunction() :
                'cancel' === e.dismiss
                && dismissFunction();
        });

    }

    function showLoading(){

        $('#loading-overlay').show();

        setTimeout(function(){
            hideLoading();
        },30000);
    }

    function hideLoading(){
        $('#loading-overlay').hide();
    }

</script>