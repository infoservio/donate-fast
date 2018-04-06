$(function() {
    const tableDom = $('#invoice-table');
    const table = tableDom.DataTable({
        "order": [[ 0, "desc" ]],
        aLengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        iDisplayLength: 10,
    });

    tableDom.find('thead th').not(':last').each(function (index) {
        let title = $(this).text();
        // because of nth-child -> starts from 1, but we should miss first column
        index += 1;
        tableDom.find('tfoot').css('display', 'table-header-group');
        tableDom.find('tfoot').find('th:nth-child(' + index + ')').html('<input class="form-control" type="text" placeholder="Search by '+ title +'"/>');
    });

    table.columns().every( function () {
        let that = this;

        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        });
    });

    $('.send-email').click(function () {
        if (confirm("Are you sure?")) {
            $.ajax({
                type: "POST",
                url: '/admin/donate-fast/invoice/send',
                data: { id: $(this).attr('value')}
            });
        }
        return false;
    });
});