<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Bootstrap</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Modal Header</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                Are you sure you want to delete this note?
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <!-- Utilisation de PHP pour inclure la variable $idNote dans les liens -->
                <a href="validate"><button type="button" class="btn btn-success">Validate</button></a>
                <a href="close"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
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
