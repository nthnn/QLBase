<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP POST Form</title>
</head>
<body>

<h1>HTTP POST Form</h1>

<form id="postForm" onsubmit="submitForm(event)">
    <label for="subject">Choose a file:</label>
    <input type="file" id="subject" name="subject" required>
    <br>

    <label for="headersInput">HTTP Headers:</label>
    <textarea id="headersInput" name="headersInput" rows="5" cols="50"></textarea>
    <br>

    <label for="postContentInput">POST Content:</label>
    <textarea id="postContentInput" name="postContentInput" rows="5" cols="50"></textarea>
    <br>

    <input type="submit" value="Submit">
</form>

<script>
    function submitForm(event) {
        event.preventDefault();

        const uploadFile = async ({ url, fileName, fileData }) => {
            const data = new FormData();

            var formData = new FormData();
            data.append(fileName, fileData);

            try {
                return await fetch(url, {
                    method: "POST",
                    headers: JSON.parse(document.getElementById("headersInput").value),
                    body: data
                });
            }
            catch(err) {
                return null;
            }
        };

        const fileInput = document.querySelector("#subject");
        uploadFile({
            url: "http://localhost:8080/QLBase/api/index.php?action=file_upload",
            fileName: "subject",
            fileData: fileInput.files[0]
        }).then(response => response.json())
        .then(data => console.log("Data: " + JSON.stringify(data)))
        .catch(error => console.error("Error: " + error));
    }
</script>

</body>
</html>
