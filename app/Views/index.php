<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>


<div class="container">

<duv class="row">
<div class="col-md-8">

<?php foreach($tasks as $tasksData){ ?>

<div class="card mt-4"  id="cart_id_<?= $tasksData->id ?>" >
  <div class="card-header">
   <?= $tasksData->title ?>
  </div>
  <div class="card-body">
    <h5 class="card-title"> <?= $tasksData->date ?></h5>
    <p class="card-text"> <?= $tasksData->details ?></p>
    <button class="btn btn-primary float-end" id="edit_button" onclick="editToDo('<?= $tasksData->id ?>')">Edit</button>
    <button class="btn btn-danger float-end" id="delete_button" onclick="deleteData('<?= $tasksData->id ?>')" style="margin-right: 10px;">Delete</button>
    </div>
</div>
<?php } ?>






    </div>


<div class="col-md-4">

<div class="card mt-4">
 <div class="card-body">
    <h5 class="card-title">To do</h5>
    <div id="to_do_list_form_container">
    <form id="to_do_list_form" >
    <div class="mb-3">
    <label for="Title" class="form-label text-center" >Title</label>
    <input type="text" name="title" class="form-control" >
  </div>

  <div class="mb-3">
    <label for="details" class="form-label">Details</label>
    <textarea name="details" class="form-control" ></textarea>
  </div>

  <div class="mb-3">
    <label for="date" class="form-label">Date</label>
    <input type="datetime-local" name="date"   class="form-control">
  </div>
 <button type="button" value="submit"  id="to_do_list_form_btn" class="btn btn-primary">Submit</button>
</form>
    </div>
 



  </div>
</div>

</div>


</duv>






</div>



<script src="https://code.jquery.com/jquery-3.7.1.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>

function populateForm(taskData) {
        var formHTML = `
            <form id="to_do_list_form" >
            <input type="hidden" name="id" class="form-control" value="${taskData.id}">

                <div class="mb-3">
                    <label for="Title" class="form-label text-center">Title</label>
                    <input type="text" name="title" class="form-control" value="${taskData.title}">
                </div>
                <div class="mb-3">
                    <label for="details" class="form-label">Details</label>
                    <textarea name="details" class="form-control">${taskData.details}</textarea>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="datetime-local" name="date" class="form-control" value="${taskData.date}">
                </div>
                <button type="button" value="submit" id="to_do_list_update_form_btn" class="btn btn-primary">Submit</button>
            </form>
        `;
        $('#to_do_list_form_container').html(formHTML);
    }



$("#to_do_list_form_btn").on("click", function() {
    $(".error-message").remove();

    // Check if any form fields are empty
    let emptyFields = $("#to_do_list_form").find(':input').filter(function() {
        return $(this).val() === "";
    });

    if (emptyFields.length > 0) {
        emptyFields.each(function() {
            $(this).after("<p class='error-message' style='color:red'>This field is required</p>");
        });
    } else {
        let formData = $("#to_do_list_form").serialize();

        $.ajax({
            type: 'post',
            url: 'add-or-update-to-do-data',
            data: formData,
            success: function(res) {
                if (res.status == 'ok') {
                    alert(res.message);
                    $('#to_do_list_form')[0].reset();
                    location.reload();

                } else {
                    alert(res.message);
                }
            }
        });
    }
});

function editToDo(id){
    $.ajax({
            type: 'post',
            url: 'get-to-do-list-by-id',
            data: {
                id:id
            },
            success: function(res) {
                if (res.status == 'ok') {
                    populateForm(res.data);

                } else {
                    alert(res.message);
                }
            }
        });
   
}







$('#to_do_list_form_container').on('click', '#to_do_list_update_form_btn', function() {
    var title = $('#to_do_list_form input[name="title"]').val();
    var details = $('#to_do_list_form textarea[name="details"]').val();
    var date = $('#to_do_list_form input[name="date"]').val();

    if (title.trim() === '' || details.trim() === '' || date.trim() === '') {
        alert('Please fill in all fields');
        return;
    }

    var formData = $('#to_do_list_form').serialize();
    $.ajax({
        url: 'add-or-update-to-do-data',
        method: 'POST',
        dataType: 'json',
        data: formData,
        success: function(res) {
            if (res.status == 'ok') {
                alert(res.message);
                location.reload();
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
});

function deleteData(id){
   $.ajax({
    url: 'delete-to-do-data',
        method: 'POST',
        dataType: 'json',
        data: {
            id:id
        },
        success: function(res) {
            if (res.status == 'ok') {
                $("#cart_id_"+id).remove()
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
   })
}


</script>  

</body>
</html>