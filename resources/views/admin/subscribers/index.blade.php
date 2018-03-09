@extends('admin/layouts.app')

@section('custom_css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.5/css/select.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
@endsection

@section('content')
<div class="card">
    <div class="card-header">Subscribers - View All</div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-bordered" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Active</th>
                        <th>Created On</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                     <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<form action="#" method="post" id="deletItemForm" display: none;>
    @csrf
    {{ method_field('DELETE') }}
</form>
@endsection

@section('custom_js')
<!-- Required: Datatable -->
<script src="https:////cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<!-- Utilities for Datatable -->
<script src="https://cdn.datatables.net/select/1.2.5/js/dataTables.select.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        processing: true,
        "language": {
            "processing": '<i class="text-primary fas fa-circle-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            "emptyTable": "No Subscribers Found.",
            "oPaginate": {
                sNext: 'Next <i class="fas fa-chevron-right"></i>',
                sPrevious: '<i class="fas fa-chevron-left"></i> Previous',
                sFirst: '<i class="fas fa-step-backward"></i> First',
                sLast: 'Last <i class="fas fa-step-forward"></i>'
            },
        },
        serverSide: true,
        ajax: '{!! route('subscribers.ajaxData') !!}',
        columns: [
            { data: 'id', name: 'subscribers.id' },
            { data: 'email', name: 'email' },
            { data: 'is_active', name: 'is_active' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions' }
        ],
        "order": [[ 3, "desc" ]],
        "columnDefs": [
            { orderable: false, targets: [4] }
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if (column[0][0] !== 4) {
                    var input = document.createElement("input");
                    input.className = 'form-control form-control-sm';
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? val : '', true, false).draw();
                    });
                }
            });
        },
        "pagingType": "full_numbers",
        "deferRender": true,
        buttons: [
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy All',
                className: 'btn btn-sm btn-secondary',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'collection',
                text: '<i class="fas fa-download"></i> Export Data',
                className: 'btn btn-sm btn-secondary',
                buttons: [
                    {
                        extend: 'csv',
                        text: 'As CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'As Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'As PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ]
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print all',
                className: 'btn btn-sm btn-secondary',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i class="far fa-eye-slash"></i> Show/Hide Columns',
                className: 'btn btn-sm btn-secondary',
                columnText: function ( dt, idx, title ) {
                    if (idx == 4) {
                        return 'Actions';
                    } else {
                        return title;
                    }
                }
            },
        ],
        dom: 'lBfrtip',
    });
    $('.dt-buttons button, .dt-button-collection button').removeClass('dt-button');
});

// Admin helpers
function callDeletItem(id, model) {
    if (confirm('Are you sure?')) {
        $("#deletItemForm").attr('action', base_url + '/admin/'+ model + '/' + id);
        $("#deletItemForm").submit();
    }
}
</script>
@endsection
