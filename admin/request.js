// Listen for changes in the status fields
document.addEventListener('input', function(event) {
    if (event.target.id.startsWith('status_')) {
      var statusInput = event.target;
      var permissionId = statusInput.id.split('_')[1];
  
      // Validate the new status
      var newStatus = statusInput.value;
      if (newStatus === '0' || newStatus === '1') {
        // Update the status in the database using AJAX or form submission
        // Example AJAX code:
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('permission_id=' + permissionId + '&status=' + newStatus);
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            alert('Status updated successfully!');
          }
        };
      } else {
        alert('Invalid status. Please enter either 0 or 1.');
        // Reset the value if an invalid status is entered
        statusInput.value = '0';
      }
    }
  });
  