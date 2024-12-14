<!-- Start Footer Section -->
<footer class="footer-section">
    <div class="container relative" style=" margin-bottom: -50px;">

        <div class="sofa-img" style="margin-top:60px;">
            <img src="/public/images/sofa.png" alt="Image" class="img-fluid">
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="subscription-form">
                    <h3 class="d-flex align-items-center">
                        <span class="me-1">
                            <img src="/public/images/envelope-outline.svg" alt="Image" class="img-fluid">
                        </span>
                        <span>Subscribe to Newsletter</span>
                    </h3>

                    <form class="row g-3" id="subscribeForm">
                        <div class="col-auto">
                            <input type="text" class="form-control" placeholder="Enter your name" id="name"
                                   name="first_name">
                        </div>
                        <div class="col-auto">
                            <input type="email" class="form-control" placeholder="Enter your email" id="email"
                                   name="email">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-paper-plane"></span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="row g-5 mb-5">
            <div class="col-lg-4">
                <div class="mb-4 footer-logo-wrap"><a href=" " class="footer-logo">Nest & Buy </a></div>
                <p class="mb-4">At Nest & Buy, we bring you stylish, high-quality furniture to make your
                    home
                    cozy
                    and beautiful. With a focus on craftsmanship and design, we’re here to help you create
                    spaces
                    you love.
                </p>

                <ul class="list-unstyled custom-social">
                    <li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
                    <li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
                </ul>
            </div>

            <div class="col-lg-8">
                <div class="row links-wrap">
                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="/customers/about">About us</a></li>
                            <li><a href="/customers/shop">Shop</a></li>
                            <li><a href="/customers/contact">Contact us</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="/customers/index#category"">Category</a></li>
                            <li><a href="/customers/shop"">Product</a></li>
                            <li><a href="/customers/index#bserseller">Best seller</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <li><a href="/customers/index#testimonial">Testimonials</a></li>
                            <li><a href="/customers/about#ourTeam">Our team</a></li>
                        </ul>
                    </div>

                    <div class="col-6 col-sm-6 col-md-3">
                        <ul class="list-unstyled">
                            <img src="/public/images/Logo (2).png" style="max-width: 130px;">
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-top copyright">
            <div class="row pt-4">
                <div class="col-lg-6">
                    <p class="mb-2 text-center text-lg-start">Copyright &copy;
                        <script>document.write(new Date().getFullYear());</script>
                        . All Rights Reserved.
                        &mdash;
                        Designed with love by Nest & Buy
                    </p>
                </div>


                <div class="col-lg-6 text-center text-lg-end">
                    <ul class="list-unstyled d-inline-flex ms-auto">
                        <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Chatbot -->
    <div id="chatbot" class="container-fluid d-flex flex-column p-3"
         style="max-width: 300px; border-radius: 8px; position: fixed; bottom: 20px; right: 20px; display: none; transition: all 0.3s ease;">
        <!-- Chatbot header with close button -->
        <div id="chatbot-header" class="chatbot-header p-2 rounded-top d-none"
             style="font-size: 14px; display: flex; flex-direction: column; background-color: #f1f1f1; position: relative;">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0" style="font-size: 14px;">Chat with us!</h4>
                <!-- Close Button (inside header) -->
                <button id="close-chatbot" onclick="toggleChat()" class="btn btn-sm btn-link"
                        style="font-size: 14px; color: #333; border: none; background: transparent;">
                    X
                </button>
            </div>

            <!-- Chatbot messages container -->
            <div id="chatbot-messages" class="chatbot-messages p-3"
                 style="background-color: #f7f7f7; overflow-y: auto; height: 200px;">
                <!-- Messages will appear here -->
            </div>

    <!-- Input and Send button -->
    <div id="chatbot-input-container" class="chatbot-input-container d-flex p-2" 
         style="background-color: #f1f1f1; display: none;">
        <input type="text" id="user-message" class="form-control me-2" placeholder="Type..." 
               style="font-size: 12px; padding: 5px;"/>
        <button id="send-button" class="btn btn-primary btn-sm" onclick="sendMessage()" style="font-size: 12px;">Send</button>
    </div>
</div>
<!-- End Chatbot -->

    <!-- Robot Icon (Initially small and clickable) -->
    <div id="robot-icon-container" onclick="toggleChat()"
         class="position-fixed bottom-0 end-0 mb-3 me-3 cursor-pointer">
        <span id="robot-icon" class="fas fa-robot"
              style="color: #3b5d50; font-size: 30px; border-radius: 50%; padding: 8px; background-color: #fff; box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);"></span>
    </div>

    <!-- Add Font Awesome (for the robot icon) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"/>

    <script>
        // Function to send the message
        function sendMessage() {
            const message = document.getElementById('user-message').value.trim();

            if (message === "") {
                return;
            }

            // Display the user's message
            displayMessage(message, 'user');

            // Clear input field
            document.getElementById('user-message').value = '';

            // Send message to the server via AJAX
            fetch('/chatbot/respond', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Setting content type to JSON
                    'X-Requested-With': 'XMLHttpRequest' // To signify it's an AJAX request
                },
                body: JSON.stringify({message: message}) // Send message as JSON body
            })
                .then(response => response.json())
                .then(data => {
                    // Display the bot's response
                    displayMessage(data.response, 'bot');
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayMessage("Sorry, something went wrong. Please try again.", 'bot');
                });
        }

        // Function to display messages in the chat
        function displayMessage(message, sender) {
            const messageContainer = document.createElement('div');
            messageContainer.classList.add('message', sender);

            const messageText = document.createElement('p');
            messageText.textContent = message;
            messageContainer.appendChild(messageText);

            if (sender === 'bot') {
                // Add a small robot icon for the bot message
                const robotIcon = document.createElement('span');
                robotIcon.classList.add('fas', 'fa-robot');  // Font Awesome robot icon
                robotIcon.classList.add('robot-icon', 'me-2');
                messageContainer.prepend(robotIcon);
            }

            document.getElementById('chatbot-messages').appendChild(messageContainer);

            // Scroll to the bottom
            const messagesDiv = document.getElementById('chatbot-messages');
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        // Function to toggle the chatbot visibility (show and hide)
        function toggleChat() {
            const chatbot = document.getElementById('chatbot');
            const robotIconContainer = document.getElementById('robot-icon-container');
            const chatbotHeader = document.getElementById('chatbot-header');
            const chatbotMessages = document.getElementById('chatbot-messages');
            const chatbotInputContainer = document.getElementById('chatbot-input-container');

            if (chatbot.style.display === "none" || chatbot.style.display === "") {
                // Show the chatbot and expand it
                chatbot.style.display = "flex";
                chatbot.style.maxHeight = "600px"; // Increased height
                chatbot.style.maxWidth = "400px"; // Slightly wider
                chatbotHeader.classList.remove('d-none'); // Show the header
                chatbotMessages.classList.remove('d-none'); // Show the messages container
                chatbotMessages.style.height = "350px"; // Increase the message area height
                chatbotInputContainer.classList.remove('d-none'); // Show the input and send button
                robotIconContainer.style.display = "none"; // Hide the robot icon when the chatbot is visible
            } else {
                // Hide the chatbot and collapse it back to small size
                chatbot.style.display = "none";
                chatbot.style.maxHeight = "100px"; // Keep it small
                chatbot.style.maxWidth = "300px"; // Keep it narrow
                chatbotHeader.classList.add('d-none'); // Hide the header
                chatbotMessages.classList.add('d-none'); // Hide the messages container
                chatbotInputContainer.classList.add('d-none'); // Hide the input and send button
                robotIconContainer.style.display = "block"; // Show the robot icon again
            }
        }

        // CSS class for user and bot messages
        const styles = `
        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            max-width: 80%;
            word-wrap: break-word;
            display: flex;
            align-items: center;
        }
        .message.user {
            background-color: #d1ecf1;
            align-self: flex-end;
            text-align: right;
        }
        .message.bot {
            background-color: #d4edda; /* Success color for bot */
            align-self: flex-start;
            text-align: left;
        }
        .robot-icon {
            color: #28a745; /* Success color for robot */
            font-size: 1em; /* Make the robot icon small */
            margin-right: 5px;
        }
        .chatbot-input-container input {
            flex: 1;
            font-size: 12px;
            padding: 5px;
        }
        .chatbot-header h4 {
            font-size: 14px; /* Make header text smaller */
        }

        /* Ensure the message container has a consistent flex direction */
        #chatbot-messages {
            display: flex;
            flex-direction: column; /* Stack the messages vertically */
            overflow-y: auto;
            flex-grow: 1;
            padding: 10px;
            max-height: 350px; /* Adjust the height based on your requirement */
        }

        /* Smooth scrolling for the messages container */
        #chatbot-messages {
            scroll-behavior: smooth;
        }
        #chatbot-input-container {
    display: none;
}

    `;
        const styleSheet = document.createElement("style");
        styleSheet.type = "text/css";
        styleSheet.innerText = styles;
        document.head.appendChild(styleSheet);
    </script>


</footer>
<!-- End Footer Section -->


<script src="/public/js/main.js"></script>
<script src="/public/js/logout.js"></script>
<script src="/public/js/bootstrap.bundle.min.js"></script>
<script src="/public/js/tiny-slider.js"></script>
<script src="/public/js/custom.js"></script>
<script src="/public/https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="/public/https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="/public/https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>