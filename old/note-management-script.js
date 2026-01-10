const form = document.getElementById('registerNoteForm');

// Handles the HTTP request that the html would of had to send to the php file
form.addEventListener('submit', function(e) {
    // Stops the default behaviour, making the script handle
    // submissions
    e.preventDefault();
    // Gather form inputs using their names an format
    const formData = new FormData(form);
    // Sends a http request to the target "note_management.php"
    // with the data, defining the method
    fetch('note_management.php', {
        method: 'POST',
        body: formData
    })
    // Long string of data that is turned into a string
    .then(response => response.text())
    .then(data => {
        console.log("PHP response:", data); // see server output
        alert("Note submitted successfully.");
    })
    // Catches fetch errors including those to do with the network
    .catch(error => console.error('Error:', error));
});

document.addEventListener("DOMContentLoaded", function(e) {
    fetch('note_management.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            action: "get_notes"
        })
    })
    .catch(error => console.error('Error:', error));

    fetch('note_management.php')
    .then(result => result.json())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
});

