var cursor = 0;
function deleteAction(categoryId){
    $('#deleteModal').modal('show', categoryId);
    cursor = categoryId;
}
function deleteConfirm(){
    //window.location.replace("delete?id=" + cursor);

    var formData = {
        cid:cursor
    }; //Array

    $.ajax({
        url : "delete",
        type: "POST",
        data : formData,
        success: function(data, textStatus, jqXHR)
        {
            window.location.replace("list");
            //data - response from server
            //alert(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //window.location.replace("list");
            //alert('error')
        }
    });
}

function editAction(categoryId){
    //alert($('#Q' + id + 'C').text());
    $('#editModal').modal('show');
    cursor = categoryId;

    $("#subject").val($('#C' + categoryId).text());
}

function editConfirm(){
    //window.location.replace("delete?id=" + cursor);

    var formData = {
        cid:cursor,
        newName:$('#subject').val()
    }; //Array

    $.ajax({
        url : "edit",
        type: "POST",
        data : formData,
        success: function(data, textStatus, jqXHR)
        {
            window.location.replace("list");
            //data - response from server
            //alert(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            //window.location.replace("list");
            //alert('error')
        }
    });
}