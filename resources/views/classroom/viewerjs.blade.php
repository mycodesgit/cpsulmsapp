<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Viewer</title>
</head>
<body>
    <h1>File Viewer</h1>
    <div id="file-viewer">
        <!-- Embed files based on their type -->
        <iframe id="file-frame" width="100%" height="600px" frameborder="0"></iframe>
    </div>

    <script>
        // Get the filename from the URL parameters
        const params = new URLSearchParams(window.location.search);
        const fileName = params.get('filename'); // Get the filename from the URL
        const filePath = 'storage/topics/' + fileName; // Construct the file path
        const fileType = fileName.split('.').pop(); // Get file extension

        let viewerUrl = '';

        // Determine the viewer URL based on file type
        if (fileType === 'pdf') {
            viewerUrl = `https://viewerjs.org/#${filePath}`; // Use ViewerJS for PDF
        } else if (fileType === 'docx' || fileType === 'pptx') {
            viewerUrl = `https://docs.google.com/gview?url=${encodeURIComponent(filePath)}&embedded=true`; // Use Google Docs Viewer for DOCX and PPT
        } else {
            viewerUrl = ''; // Handle unsupported file types
            alert('Unsupported file type');
        }

        // Set iframe source
        document.getElementById('file-frame').src = viewerUrl; 
    </script>
</body>
</html>
