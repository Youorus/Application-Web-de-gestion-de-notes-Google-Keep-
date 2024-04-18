<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class=" modal-content">

            <!-- Modal Header -->
            <div class="bg-back modal-header">
                <h4 class="modal-title">Modal Header</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="bg-back modal-body">
                Are you sure you want to delete <span class="text-danger">"<?= $title ?></span> ?


            </div>

            <!-- Modal Footer -->
            <div class=" bg-back modal-footer">
                <!-- Utilisation de PHP pour inclure la variable $idNote dans les liens -->
                <a class="btn btn-success" href="delete/validate/<?= $idNote ?>">Validate</a>
                <a class="btn btn-danger" href="delete/close/<?= $idNote ?>">Close</a>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript pour ouvrir le modal automatiquement -->
<script>
    $(document).ready(function(){
        $('#myModal').modal('show');
    });
</script>

</body>
</html>
