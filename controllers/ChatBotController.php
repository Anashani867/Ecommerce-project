<?php
class ChatbotController extends Controller
{
    public function index()
    {
        // Load the chatbot view
        include 'views/partials/footer.php';
    }

    // Method to handle chatbot response (for AJAX requests)
    public function respond()
    {
        // Ensure the session is started before accessing session data
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Retrieve the raw POST data and decode the JSON
        $input = json_decode(file_get_contents('php://input'), true);

        // Check if the message exists
        $userMessage = isset($input['message']) ? trim($input['message']) : '';

        // Check if the message is not empty
        if (empty($userMessage)) {
            echo json_encode(['response' => "Please type something to ask."]);
            return;
        }

        // Example: Assuming we have the customer ID (could be from a session or a user login system)
        $customerId = $_SESSION['customer_id'] ?? null;

        if ($customerId) {
            // Fetch the user's orders from the database using the customer ID
            $orderModel = $this->model('Order'); // Assuming you have an Order model for handling orders
            $userOrders = $orderModel->getOrdersByCustomerId($customerId);
            // Debugging: Check if orders are being fetched correctly
            if (empty($userOrders)) {
                echo json_encode(['response' => "No orders found for your account."]);
                return;
            }
        } else {
            // If no customer ID is found, you can return a generic response or handle it accordingly
            $userOrders = [];
        }

        // Process the message and generate the bot's response
        $botResponse = $this->getBotResponse($userMessage);

        // Return the response as JSON
        echo json_encode(['response' => $botResponse]);
    }

    // Simple method to generate a bot response (expand as needed)
    private function getBotResponse($message)
    {
        // Convert message to lowercase for simpler matching
        $message = strtolower($message);

        // Handle greetings such as "hey"
        if (stripos($message, 'hey') !== false) {
            return $this->handleGreeting();
        }

        // Handle payment on delivery inquiries
        if (stripos($message, 'payment') !== false || stripos($message, 'pay on delivery') !== false) {
            return $this->handlePaymentOnDelivery();
        }

        // Handle inquiries about canceling an order
        if (stripos($message, 'refund') !== false || stripos($message, 'cancel order') !== false) {
            return $this->handleCancelOrder();
        }

        // Basic help response for any other inquiries
        if (stripos($message, 'help') !== false) {
            return $this->handleHelp();
        }

        // Default response for unrecognized inquiries
        return "I'm not sure about that. Can you try asking in another way, or check your profile for more details?";
    }

    // Helper method for greeting
    private function handleGreeting()
    {
        return "Welcome to Nest and Buy! We're an e-commerce website that offers a wide range of products. Feel free to browse our store, check out your orders, or ask about payment and shipping options. How can I assist you today?";
    }

    // Helper method for payment on delivery inquiries
    private function handlePaymentOnDelivery()
    {
        return "We offer 'Payment on Delivery' as a payment option. You can select this method during checkout, and pay for your order once it arrives at your location.";
    }

    // Helper method for canceling an order inquiries
    private function handleCancelOrder()
    {
        return "To cancel an order, please go to your profile page and click on 'Order History'. Note: You can only cancel an order within 24 hours of placing it.";
    }

    // Helper method for the help response
    private function handleHelp()
    {
        return "I'm here to assist you! Feel free to ask about your order status, payment options, canceling an order, or any other inquiries you might have.";
    }
}
?>
