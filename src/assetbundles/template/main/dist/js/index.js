$(document).ready(function() {
    $('#invoice-table').DataTable({
        "order": [[ 0, "desc" ]]
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