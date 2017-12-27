$(document).ready(function() {
    $('#invoice-table').DataTable({
        "order": [[ 0, "desc" ]]
    });

    $('.send-email').click(function () {
        if (confirm("Are you sure?")) {
            $.ajax({
                type: "POST",
                url: '/admin/billion-global-server/reminder/send',
                data: { email: $(this).attr('value')}
            });
        }
        return false;
    });
});