<?php require_once "login_signup/controllerUserData.php"; ?>
<?php
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if ($email != false && $password != false) {
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if ($run_Sql) {
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if ($status == "verified") {
            if ($code != 0) {
                header('Location: login_signup/reset-code.php');
            }
        } else {
            header('Location: login_signup/user-otp.php');
        }
    }
} else {
    header('Location: login_signup/login-user.php');
}
?>




<!DOCTYPE html>
<html lang="en">

<?php include('partials/header.php'); ?>

<body>
    <?php include 'partials/sidebar.php'; ?>
    <main class="main-wrapper">
        <?php include 'partials/navbar.php'; ?>

        <section class="section">
            <div class="container-fluid">
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title mb-30">
                                <h2>eCommerce Dashboard</h2>
                            </div>
                        </div>
                        <div class="container my-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="p-3 mb-4  shadow-3 border border-1 rounded-6">
                                        <h3>Kerko</h3>
                                        <hr class="w-25">
                                        <div id="search-form mb-3">
                                            <input type="text" id="search-input" placeholder="Search for images..."
                                                class="form-control">
                                            <br>
                                            <button class="btn btn-light shadow-2 border border-1"
                                                id="search-button">Search</button><br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 mb-4  shadow-3 border border-1 rounded-6">
                                        <h3>Asistenti juaj</h3>
                                        <hr class="w-25">
                                        <div id="response-div">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class=" p-3 mb-4  shadow-3 border border-1 rounded-6">
                                        <h3>Imazhe</h3>
                                        <hr class="w-25">
                                        <div id="image-gallery" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>


                        function searchImages() {
                            const accessKey = 'VFPrRE7L_ezwf85Bm_vo8pti4ri1V43KRUDz9KMVyR0'; // Replace with your Unsplash access key
                            const query = $('#search-input').val();
                            const apiUrl = `https://api.unsplash.com/search/photos?query=${query}`;

                            $.ajax({
                                url: apiUrl,
                                headers: {
                                    Authorization: `Client-ID ${accessKey}`
                                },
                                success: function (data) {
                                    displayImages(data.results);
                                },
                                error: function () {
                                    $('#image-gallery').html('<p>No results found.</p>');
                                }
                            });
                        }

                        function displayImages(images) {
                            const imageGallery = $('#image-gallery');
                            imageGallery.empty();

                            const renderImage = (image) => {
                                return `<div class="card">
                    <img src="${image.urls.small}" class="card-img-top" alt="${image.alt_description}">
                    <div class="card-body">
                        <p class="card-text">${image.description || 'Untitled'}</p>
                    </div>
                    </div>`;
                            };

                            images.slice(0, 3).forEach(image => {
                                const container = $('<div>').addClass('image-container');
                                const imageElement = $('<img>').attr('src', image.urls.small);
                                const sendButton = $('<button>').text('Send');
                                const downloadButton = $('<button>').text('Download');

                                sendButton.on('click', function () {
                                    // Get the URL of the image to send
                                    const imageUrl = image.urls.full;

                                    // Create a new email message with the image as an attachment
                                    const emailMessage = {
                                        subject: 'Check out this cool image',
                                        body: `Hey there,\n\nI wanted to share this awesome image with you:\n${imageUrl}\n\nEnjoy!`,
                                        attachments: [imageUrl]
                                    };

                                    // Send the email using your email service API or client-side script
                                    // For example, here's how you could use the Gmail API to send the email:
                                    // gapi.client.gmail.users.messages.send({userId: 'me', resource: {raw: btoa(JSON.stringify(emailMessage))}});

                                    // If you're not using an API, you could also open the user's email client with the message pre-filled:
                                    window.location.href = `mailto:?subject=${emailMessage.subject}&body=${emailMessage.body}`;
                                });

                                downloadButton.on('click', function () {
                                    // Get the URL of the image to download
                                    const imageUrl = image.urls.full;

                                    // Create a new XMLHttpRequest
                                    const xhr = new XMLHttpRequest();
                                    xhr.open('GET', imageUrl, true);
                                    xhr.responseType = 'blob';

                                    xhr.onload = function () {
                                        // Check if the request was successful
                                        if (xhr.status === 200) {
                                            // Create a new anchor element with the image blob as its href and download attribute set
                                            const downloadLink = $('<a>').attr({
                                                href: window.URL.createObjectURL(xhr.response),
                                                download: `${image.id}.jpg`
                                            });

                                            // Add the download link to the document body
                                            $('body').append(downloadLink);

                                            // Simulate a click on the download link to trigger the download
                                            downloadLink[0].click();

                                            // Remove the download link from the document body
                                            downloadLink.remove();
                                        }
                                    };

                                    xhr.send();
                                });




                                container.append(imageElement, sendButton, downloadButton);
                                imageGallery.append(container);

                                sendButton.addClass('btn btn-light shadow-2 border border-1 me-1 mt-1');
                                downloadButton.addClass('btn btn-light shadow-2 border border-1 mt-1');

                            });
                        }



                        $('#search-button').on('click', searchImages);




                        const apiKey = "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";

                        const apiUrl = 'https://api.openai.com/v1/engines/text-davinci-003/completions';

                        const searchInput = document.getElementById('search-input');
                        const searchButton = document.getElementById('search-button');

                        const responseDiv = document.getElementById('response-div');

                        searchButton.addEventListener('click', function () {
                            const searchQuery = searchInput.value;

                            // Construct the request body
                            const requestBody = {
                                prompt: searchQuery,
                                max_tokens: 100,
                            };

                            searchButton.disabled = true;

                            responseDiv.innerHTML = '';
                            // Make the API request using the Fetch API
                            fetch(apiUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Authorization': `Bearer ${apiKey}`
                                },
                                body: JSON.stringify(requestBody)
                            })
                                .then(response => response.json())
                                .then(data => {
                                    const text = data.choices[0].text.trim();

                                    // Use a timeout to simulate the typing effect
                                    let index = 0;
                                    const typingInterval = setInterval(function () {
                                        responseDiv.innerHTML += text.charAt(index);
                                        index++;
                                        if (index >= text.length) {
                                            clearInterval(typingInterval);
                                            searchButton.disabled = false;
                                        }
                                    }, 50);
                                })
                                .catch(error => {
                                    console.error(error);
                                    searchButton.disabled = false;
                                });
                        });




                    </script>

                </div>
            </div>


            <?php include 'partials/footer.php'; ?>


</body>

</html>