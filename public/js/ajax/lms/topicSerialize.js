toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right"
};

$(document).ready(function() {
    reloadTopics();
    $('#adtopic').submit(function(event) {
        event.preventDefault();
        //var formData = $(this).serialize();
        var formData = new FormData(this);

        $.ajax({
            url: topicCreateRoute,
            type: "POST",
            data: formData,
            processData: false, // Important: Tell jQuery not to process the data
            contentType: false,
            success: function(response) {
                if(response.success) {
                    toastr.success(response.message);
                    console.log(response);
                    $('#adtopic')[0].reset(); 
                    $('#adtopic').modal('hide');
                    $(document).trigger('topicAdded');
                    $('input[name="topicname"]').val('');
                    reloadTopics();
                } else {
                    toastr.error(response.message);
                    console.log(response);
                }
            },
            error: function(xhr, status, error, message) {
                var errorMessage = xhr.responseText ? JSON.parse(xhr.responseText).message : 'An error occurred';
                toastr.error(errorMessage);
            }
        });
    });

    // Function to document icon
    function getFileIcon(fileType) {
        switch (fileType) {
            case 'pdf':
                return 'far fa-file-pdf';
            case 'doc':
            case 'docx':
                return 'far fa-file-word';
            case 'ppt':
            case 'pptx':
                return 'far fa-file-powerpoint';
            case 'txt':
                return 'far fa-file-alt';
            // Add more file types as needed
            default:
                return 'far fa-file';
        }
    }

    // Function to date
    function formatDateTime(dateTimeString) {
        const optionsDate = { year: 'numeric', month: 'short', day: 'numeric' };
        const optionsTime = { hour: 'numeric', minute: 'numeric', hour12: true }; // 12-hour format

        const date = new Date(dateTimeString);
        const formattedDate = date.toLocaleDateString('en-US', optionsDate);
        const formattedTime = date.toLocaleTimeString('en-US', optionsTime);

        return `${formattedDate} ${formattedTime}`;
    }


    // Function to reload the topics section
   function reloadTopics() {
        const urlParams = new URLSearchParams(window.location.search);
        const schlyear = urlParams.get('schlyear');
        const semester = urlParams.get('semester');
        const id = window.location.pathname.split('/').pop(); 

        if (!id || !schlyear || !semester) {
            console.error('Missing necessary parameters.');
            return;
        }

        // Dynamically replace the showTopicRoute with the actual ID
        var showTopicRoute = topicShowRoute.replace(':id', id);
        const finalUrl = `${showTopicRoute}?schlyear=${schlyear}&semester=${semester}`;

        $.ajax({
            url: finalUrl, // Replace with the route that returns JSON
            type: 'GET',
            success: function(topics) {
                // Clear the existing topics
                $('#topicContainer').empty();

                // Iterate over the topics and build the HTML
                // topics.forEach(function(topic) {
                //     const fileExtension = topic.filedocs ? topic.filedocs.split('.').pop().toLowerCase() : '';
                //     const fileIconClass = getFileIcon(fileExtension);
                //     const formattedDateTime = formatDateTime(topic.created_at);

                //     var topicHtml = `
                //         <div class="card card-default">
                //             <div class="card-header" id="classwork">
                //                 <h4 class="card-title w-100">
                //                     <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseTwo-${topic.id}" aria-expanded="false">
                //                         <i class="fas fa-file-lines"></i>&nbsp;&nbsp; <strong>${topic.topicname}</strong>
                //                         <span class="float-right text-normal text-gray" style="font-size: 10pt">${formattedDateTime}</span>
                //                     </a>
                //                 </h4>
                //             </div>
                //             <div id="collapseTwo-${topic.id}" class="collapse" data-parent="#accordion">
                //                 <div class="card-body">
                //                     ${topic.desctopicname}
                //                 </div>
                //                 <div class="card-footer bg-white">
                //                     <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                //                         <li class="fileattached">
                //                             <span class="mailbox-attachment-icon"><i class="${fileIconClass}"></i></span>
                //                             <div class="mailbox-attachment-info">
                //                                 <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> ${topic.filedocs}</a>
                //                                 <span class="mailbox-attachment-size clearfix mt-1">
                //                                     <span>${topic.fileSize || 'Unknown size'}</span>
                //                                     <a href="${topic.fileUrl || '#'}" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                //                                 </span>
                //                             </div>
                //                         </li>
                //                     </ul>
                //                 </div>
                //             </div>
                //         </div>
                //     `;
                //     // Append the new HTML to the container
                //     $('#topicContainer').append(topicHtml);
                // });

                topics.forEach(function(topic) {
                    console.log('Topic:', topic);
                    var fileDocs = topic.filedocs ? topic.filedocs.split(',') : [];
                    const formattedDateTime = formatDateTime(topic.created_at);

                    var topicHtml = `
                        <div class="card card-default">
                            <div class="card-header" id="classwork">
                                <h4 class="card-title w-100">
                                    <a class="d-block w-100 collapsed text-dark" data-toggle="collapse" href="#collapseTwo-${topic.id}" aria-expanded="false">
                                        <i class="fas fa-file-lines"></i>&nbsp;&nbsp; <strong>${topic.topicname}</strong>
                                        <span class="float-right text-normal text-gray" style="font-size: 10pt">${formattedDateTime}</span>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo-${topic.id}" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    ${topic.desctopicname}
                                </div>
                                <div class="card-footer bg-white">
                                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                    `;

                    // Iterate over the fileDocs array to display each file
                    fileDocs.forEach(function(filePath) {
                        filePath = filePath.replace(/["\]]/g, ' ').trim(); // Remove "]" and trim any extra spaces

                        var fileType = filePath.split('.').pop().toLowerCase(); // Get the file extension
                        var fileIconClass = getFileIcon(fileType); // Get the corresponding icon

                        // Encode the file path for URLs
                        var encodedFilePath = encodeURIComponent(filePath);

                        // Construct the Google Docs viewer URL
                        var googleDocsViewerUrl = `https://docs.google.com/gview?url=${baseUrl}/storage/${encodedFilePath}&embedded=true`;

                        // Debugging: print the generated URL to the console
                        console.log('Google Docs Viewer URL:', googleDocsViewerUrl);

                        topicHtml += `
                            <li class="fileattached">
                                <span class="mailbox-attachment-icon"><i class="${fileIconClass}"></i></span>
                                <div class="mailbox-attachment-info">
                                    <a href="${googleDocsViewerUrl}" class="mailbox-attachment-name" target="_blank"><i class="fas fa-paperclip"></i> ${filePath.split('/').pop()}</a>
                                    <span class="mailbox-attachment-size clearfix mt-1">
                                        <span>${topic.fileSize || 'Unknown size'}</span>
                                        <a href="${baseUrl}/storage/${encodedFilePath}" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                    </span>
                                </div>
                            </li>
                        `;
                    });

                    topicHtml += `
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;

                    // Append the new HTML to the container
                    $('#topicContainer').append(topicHtml);
                });
            },
            error: function() {
                toastr.error('Failed to reload topics');
            }
        });
    }

    $('#fileUpload').on('change', function() {
        // Clear existing previews
        $('#filePreviewContainer').empty();

        // Get the selected files
        const files = $(this)[0].files;

        // Loop through each selected file
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileType = file.type; // Get the file type
            const fileName = file.name;
            const fileSize = (file.size / 1024).toFixed(2); // Size in KB

            // Determine the icon based on the file type
            let icon;
            if (fileType.includes('pdf')) {
                icon = 'far fa-file-pdf';
            } else if (fileType.includes('word') || fileType.includes('msword') || fileType.includes('doc')) {
                icon = 'far fa-file-word';
            } else if (fileType.includes('excel')) {
                icon = 'far fa-file-excel';
            } else if (fileType.includes('ppt') || fileType.includes('powerpoint')) {
                icon = 'far fa-file-powerpoint';
            } else {
                icon = 'far fa-file'; // Default icon for unknown types
            }

            // Create the HTML for the file preview
            const fileHtml = `
                <li class="fileattached">
                    <span class="mailbox-attachment-icon"><i class="${icon}"></i></span>
                    <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> ${fileName}</a>
                        <span class="mailbox-attachment-size clearfix mt-1">
                            <span>${fileSize} KB</span>
                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                    </div>
                </li>
            `;

            // Append the file preview to the container
            $('#filePreviewContainer').append(fileHtml);
        }
    });
});

