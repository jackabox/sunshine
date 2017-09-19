 $(document).on('change', '#github_repo', function() {
    $.ajax({
        type: 'POST',
        url: '/admin/github/releases',
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        data: {
            'repo': $(this).children('option:checked').val()
        },
        success: function(response) {
            var items = $.parseJSON(response);
            var select = $('#github_release');
            select.empty();

            if (items.length > 0) {
                $.each(items, function (i, item) {
                    select.append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            } else {
                select.append('<option value="">Repo has no releases</option>');
            }
        }
    });

    $('input[name=github_folder]').attr('placeholder', $(this).val());
});
