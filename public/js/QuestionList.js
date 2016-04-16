var cursor = 0;
function deleteAction(names){
    $('#deleteModal').modal('show', names);
    cursor = names;
}
function deleteConfirm(){
    //window.location.replace("delete?id=" + cursor);

    var formData = {
        qid:cursor
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
function editAction(id){
    //alert($('#Q' + id + 'C').text());
    $('#editModal').modal('show');
    cursor = id;

    //$('.editModal.description').val('hi');
    for(var i=1 ; i<=4 ; i++) {
        $("#a" + i).val($('#Q' + id + 'A' + i).text().trim());
    }
    $("#d").val($('#Q' + id + 'D').text());

    $('#' + $('#Q' + id + 'C').text()).attr('checked', 'checked');

}
function editConfirm(){
    //alert($('#c').text());
    //alert($('input[name=correct]:checked', '#editForm').val());
    var formData = {
        qid:cursor,
        description:$('#d').val(),
        ans1:$('#a1').val(),
        ans2:$('#a2').val(),
        ans3:$('#a3').val(),
        ans4:$('#a4').val(),
        correct:$('input[name=correct]:checked', '#editForm').val()
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