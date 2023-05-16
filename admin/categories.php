<?php include('db_connect.php'); ?>

<div class="container-fluid">

    <div class="col-lg-12">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-4">
                <form action="" id="manage-category">
                    <div class="card">
                        <div class="card-header">
                            Medical Specialties Form
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label class="control-label">Specialty</label>
                                <textarea name="name" id="" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="description" id="" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Image</label>
                                <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                            </div>
                            <div class="form-group">
                                <img src="" alt="" id="cimg">
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3" id="save-category">Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- FORM Panel -->

            <!-- Table Panel -->
			<div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
                                $i = 1;
                                $cats = $conn->query("SELECT * FROM medical_specialty ORDER BY id ASC");
                                while ($row = $cats->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td class="text-center">
                                            <img src="../assets/img/<?php echo $row['img_path'] ?>" alt="">
                                        </td>
                                        <td class="">
                                            <b><?php echo $row['name'] ?></b>
                                        </td>
                                        <td class="">
                                            <?php echo $row['description'] ?>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary edit_cat" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>" data-img_path="<?php echo $row['img_path'] ?>">Edit</button>
                                            <button class="btn btn-sm btn-danger delete_cat" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit-modal-label">Edit Medical Specialty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="edit-category-form">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" name="id">
                            <div class="form-group">
                                <label class="control-label">Specialty</label>
                                <textarea name="name" id="" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea name="description" id="" cols="30" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Image</label>
                                <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
                            </div>
                            <div class="form-group">
                                <img src="" alt="" id="edit-cimg">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3" id="update-category">Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>
<script>
    function _reset() {
        $('#cimg').attr('src', '');
        $('[name="id"]').val('');
        $('#manage-category').get(0).reset();
    }

    $('#manage-category').submit(function (e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_category',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully added", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else if (resp == 2) {
                    alert_toast("Data successfully updated", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    });

	

    $('.edit_cat').click(function () {
    var catForm = $('#edit-category-form');
    catForm.get(0).reset();
    catForm.find("[name='id']").val($(this).attr('data-id'));
    catForm.find("[name='name']").val($(this).attr('data-name'));
    catForm.find("[name='description']").val($(this).attr('data-description'));
    catForm.find("#edit-cimg").attr("src", "../assets/img/" + $(this).attr('data-img_path'));
	console.log($(this).attr('data-description'));
    $('#edit-modal').modal('show'); // Show the edit modal
});


    $('.delete_cat').click(function () {
        _conf("Are you sure to delete this medical specialty?", "delete_cat", [$(this).attr('data-id')]);
    });

    function displayImg(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function delete_cat($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_category',
            method: 'POST',
            data: { id: $id },
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }

    $('#update-category').click(function () {
    var catForm = $('#edit-category-form');
    var id = catForm.find("[name='id']").val();
    var name = catForm.find("[name='name']").val();
    var description = catForm.find("[name='description']").val();
    var img = catForm.find("[name='img']").prop('files')[0];
    var formData = new FormData();
    formData.append('id', id);
    formData.append('name', name);
    formData.append('description', description); // Add this line to include the description field
    formData.append('img', img);

    start_load();
    $.ajax({
        url: 'ajax.php?action=save_category',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function (resp) {
            if (resp == 1) {
                alert_toast("Data successfully updated", 'success');
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }
        }
    });
});

</script>
