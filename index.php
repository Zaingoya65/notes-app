<?php
// Connecting with the DB
$server = 'localhost';
$username = 'root';
$password = '';
$db = "notes";

$conn = mysqli_connect($server, $username, $password, $db);

if ($conn) {
    //echo 'Connected to DB';
} else {
    die('We are facing the technical error. Our Team is working on it. Not connected to DB: ' . mysqli_connect_error());
}

// Handle Delete Request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    if (!empty($id)) {
        $delete = "DELETE FROM `notes` WHERE `s.no` = $id";
        $result = mysqli_query($conn, $delete);

        if ($result) {
            echo "<script>alert('Note deleted successfully!');</script>";
            echo "<script>window.location.href = window.location.href;</script>";
        } else {
            echo "Error deleting note: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('ID is required to delete a note.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD WebApp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <style>
    body {
        background-color: #f8f9fa; 
        font-family: 'Arial', sans-serif;
  
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    
    }

    .container h2 {
        color: #495057;
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        margin-top: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th {
        background-color: #6c757d;
        color: white;
        text-align: center;
    }

    td {
        vertical-align: middle;
    }

    .btn {
        margin-right: 5px;
    }

    form {
        margin: 0;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #007bff; 
        color: white;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-secondary {
        color: #495057;
    }

    <style>
    body {
        background-color: #f8f9fa; 
        font-family: 'Arial', sans-serif;
    }

    .container h2 {
        color: #495057; 
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        margin-top: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th {
        background-color: #6c757d;
        color: white;
        text-align: center;
    }

    td {
        vertical-align: middle;
    }

    .btn {
        margin-right: 5px;
    }

    form {
        margin: 0;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-header {
        background-color: #007bff; 
        color: white;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-secondary {
        color: #495057;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        table {
            font-size: 14px;
        }

        .btn {
            margin-bottom: 5px;
            width: 100%;
        }

        .modal-dialog {
            max-width: 100%;
            margin: 10px;
        }

        .form-label {
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {
        table {
            font-size: 12px;
        }

        .modal-header h5 {
            font-size: 18px;
        }

        .modal-body input, .modal-body textarea {
            font-size: 14px;
        }

        .modal-footer button {
            width: 100%;
        }
    }
</style>

</style>

</head>
<body>
<div class="container my-4">
    <form method="POST">
        <h2>Add a note</h2>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Note Title</label>
            <input name="title" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Title">
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Note Description</label>
            <textarea name="description" class="form-control" id="desc" rows="3"></textarea>
        </div>
        <button name="submit" type="submit" class="btn btn-primary mb-3">Add Note</button>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $insert = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title','$description')";
    $result = mysqli_query($conn, $insert);

    if (!$result) {
        echo "Note is Not Added Succesfully. Facing an error. Please Try Again. or Contact US Error inserting note: " . mysqli_error($conn);
    }
}
?>

<!-- Stored Data -->
<div class="container">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col" style="text-align: center;">S.No</th>
            <th scope="col" style="text-align: center;">Note Title</th>
            <th scope="col" style="text-align: center;">Description</th>
            <th scope="col" style="text-align: center;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $select = "SELECT * FROM `notes`";
        $result = mysqli_query($conn, $select);
        $i = 1;
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $shortDescription = strlen($row['description']) > 50 
                    ? substr($row['description'], 0, 50) . '...' 
                    : $row['description'];
                echo "<tr>
                        <th scope='row' style='text-align: center;'>" . $i . "</th>
                        <td style='text-align: center;'>" . htmlspecialchars($row['title']) . "</td>
                        <td style='text-align: center;' title='" . htmlspecialchars($row['description']) . "'>" . htmlspecialchars($shortDescription) . "</td>
                        <td style='text-align: center;'>
                            <button class='btn btn-primary btn-sm edit' data-id='" . $row['s.no'] . "' data-title='" . htmlspecialchars($row['title']) . "' data-description='" . htmlspecialchars($row['description']) . "' data-bs-toggle='modal' data-bs-target='#exampleModal'>Edit</button>
                            <form method='POST' style='display:inline-block;'>
                                <input type='hidden' name='id' value='" . $row['s.no'] . "'>
                                <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                $i++;
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        ?>
        </tbody>
    </table>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editId">
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Note Title</label>
                        <input name="title" type="text" class="form-control" id="editTitle">
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Note Description</label>
                        <textarea name="description" class="form-control" id="editDescription" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update" class="btn btn-primary">Update Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  //handle modal
    let editButtons = document.querySelectorAll('.edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const description = this.getAttribute('data-description');

            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
        });
    });
</script>

<?php
// Handle Update Request
if (isset($_POST['update'])) {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $description = $_POST['description'];

  if (!empty($id) && !empty($title) && !empty($description)) {
      $update = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `s.no` = $id";
      $result = mysqli_query($conn, $update);

      if ($result) {
          echo "<script>alert('Note updated successfully!');</script>";
          echo "<script>window.location.href = window.location.href;</script>";
      } else {
          echo "Note Not Updated Succeafully! Pleae try again. Or Reach out our Technical Team. Error updating note: " . mysqli_error($conn);
      }
  } else {
      echo "<script>alert('All fields are required for updating a note.');</script>";
  }
}

?>

</body>
</html>
