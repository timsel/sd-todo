/**
 * modify task via ajax call
 */
$('.taskedit').on('click', function () {
    var id = $(this).data('id');
    $.ajax({
        type: "GET",
        url: "task/" + id,
        data: "",
        dataType: "json",
        async: true,
        success: function (resp) {
            $("#taskform button").html('Modify task');
            $("#taskform input").val(resp.title);
            $("#taskform textarea").val(resp.description);
            $("input[name=id]").val(id);
        },
        error: function (msg) {
            // todo: error handling
        }
    });
    return false;
});

/**
 * delete task via ajax call
 */
$('.taskdel').on('click', function () {
    var id = $(this).data('del-id');
    $.ajax({
        type: "DELETE",
        url: "task/" + id,
        data: "_token=" + $("input[name=_token]").val(),
        dataType: "json",
        async: true,
        success: function (resp) {
            $("[data-li-id=" + id + "]").remove();
        },
        error: function (msg) {
            // todo: error handling
        }
    });
    return false;
});

/**
 * toggle task via ajax call
 */
$("[data-done-id]").on('click', function () {
    var id = $(this).data('done-id');
    var e = $(this);
    console.log(e);
    $.ajax({
        type: "POST",
        url: "task/toggle/" + id,
        data: "_token=" + $("input[name=_token]").val(),
        dataType: "json",
        async: true,
        success: function (resp) {
            console.log(resp);
            e.prop("checked", !e.prop("checked"));
            if (resp.current == 'done') {
                e.siblings('a').addClass('done');
            } else {
                e.siblings('a').removeClass('done');
                e.parent().removeClass('done');
            }
        },
        error: function (msg) {
            // todo: error handling
        }
    });
    return false;
});

/**
 * toggle show all state
 */
$('#showall').change(function () {
    $("input[name=state]").val($('#showall').prop('checked'));
    $("#showallform").submit();
});

/**
 * submit form
 */
$("#taskform").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "task/" + $("input[name=id]").val(),
        data: "_token=" + $("input[name=_token]").val() + '&title=' + $("input[name=title]").val() + '&description=' + $("textarea").val(),
        dataType: "json",
        async: true,
        success: function (msg) {
            if (msg.status) {
                if ($("input[name=id]").val()) {
                    // modify task
                    $('[data-id="' + $("input[name=id]").val() + '"]').html(
                        $("input[name=title]").val() + ' ' + msg.data.created_at_human
                    );
                    $("#taskform button").html('Add task');
                    $("#taskform input").val('');
                    $("#taskform textarea").val('');
                    $("input[name=id]").val('');
                } else {
                    // new task
                    location.reload();
                }
            } else {
                // something went wrong
                msg.errors.forEach(function (e) {
                    alert(e);
                });
            }
        },
        error: function (msg) {
            // todo: ajax error handling
        }
    });
    return false;
});

