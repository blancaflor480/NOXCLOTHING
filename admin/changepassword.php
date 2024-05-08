<div class="modal fade" id="changepassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="changePasswordForm" action="" method="bk_changepass.php">
          <div class="mb-3">
            <label for="oldPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="oldPassword" name="oldPassword">
          </div>
          <div class="mb-3">
    <label for="newPassword" class="form-label">New Password</label>
    <input type="password" class="form-control" id="newPassword" name="newPassword">
</div>
<div class="mb-3">
    <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
    <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" onkeyup="checkPasswordMatch()">
    <span id="passwordMatch"></span>  
</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="changePassword()">Save changes</button>

      </div>
    </div>
  </div>
</div>

<script>
function checkPasswordMatch() {
    var newPassword = document.getElementById('newPassword').value;
    var confirmNewPassword = document.getElementById('confirmNewPassword').value;
    var passwordMatch = document.getElementById('passwordMatch');

    if (newPassword === confirmNewPassword) {
        passwordMatch.innerHTML = "Passwords match.";
        passwordMatch.style.color = 'green';
    } else {
        passwordMatch.innerHTML = "Passwords do not match.";
        passwordMatch.style.color = 'red';
    }
}

function changePassword() {
    var oldPassword = document.getElementById('oldPassword').value;
    var newPassword = document.getElementById('newPassword').value;
    var confirmNewPassword = document.getElementById('confirmNewPassword').value;

    // Check if any field is empty
    if (oldPassword === '' || newPassword === '' || confirmNewPassword === '') {
        alert("Please fill in all fields.");
        return;
    }

    // Check if new password matches confirm password
    if (newPassword !== confirmNewPassword) {
        alert("Passwords do not match.");
        return;
    }

    // Send the form data to the server using AJAX
    var formData = new FormData();
    formData.append('oldPassword', oldPassword);
    formData.append('newPassword', newPassword);
    formData.append('confirmNewPassword', confirmNewPassword);

    // Example using fetch API
    fetch('bk_changepass.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Display server response
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred. Please try again later."); // Display error message
    });
}
</script>