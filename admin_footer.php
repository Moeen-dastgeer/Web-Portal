</div> <!-- /.content-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
function fetchStudents() {
  $.ajax({
    url: 'ajax_fetch_students.php',
    method: 'POST',
    data: $('#filterForm').serialize(),
    success: function (data) {
      $('#students_table').html(data);
    }
  });
}

$(document).ready(function () {
  fetchStudents(); // initial load

  $('#filterForm select, #filterForm input[name="search"]').on('change keyup', function () {
    clearTimeout(this.delay);
    this.delay = setTimeout(fetchStudents, 300);
  });
});

function updateStatus(id, status) {
  $.post('update_student_status.php', { id: id, status: status }, function (res) {
    alert(res);
  });
}


function openMigrateModal(studentId) {
  // Set student id in hidden input
  $('#migrate_student_id').val(studentId);

  // Show modal
  $('#migrateModal').modal('show');
}

$(document).on('click', '.migrate', function() {
    const studentId = $('#migrate_student_id').val();
    const newCampusId = $('#new_campus_id').val();

    if (!newCampusId) {
      alert('Please select a campus.');
      return;
    }

    // AJAX call using jQuery
    $.ajax(
    
      {
      url: 'migrate_student.php',
      type: 'POST',
      data: {
        student_id: studentId,
        new_campus_id: newCampusId
      },
      success: function(response) {
        alert(response);
       location.reload();
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        alert('An error occurred while migrating the student.');
      }
    }
  );
  });


</script>

</body>
</html>
<?php
ob_end_flush();
?>
