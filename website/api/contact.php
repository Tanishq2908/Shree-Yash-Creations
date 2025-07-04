<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Validate required fields
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'All required fields must be filled']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email address']);
    exit;
}

// Sanitize inputs
$name = htmlspecialchars(trim($name));
$email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($phone));
$subject = htmlspecialchars(trim($subject));
$message = htmlspecialchars(trim($message));

// Prepare email content
$to = 'shreeyashcreations.2013@gmail.com';
$emailSubject = "New Contact Form Submission: $subject";

$emailBody = "
New contact form submission from Shree Yash Creations website:

Name: $name
Email: $email
Phone: $phone
Subject: $subject

Message:
$message

---
This message was sent from the contact form on Shree Yash Creations website.
";

$headers = [
    'From' => $email,
    'Reply-To' => $email,
    'X-Mailer' => 'PHP/' . phpversion(),
    'Content-Type' => 'text/plain; charset=UTF-8'
];

// Send email
$mailSent = mail($to, $emailSubject, $emailBody, $headers);

if ($mailSent) {
    // Store in database if needed
    try {
        require_once '../config.php';
        $pdo = getDBConnection();
        
        // Create contacts table if not exists
        $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        // Insert contact form submission
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $subject, $message]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your message! We will get back to you soon.'
        ]);
    } catch (Exception $e) {
        // Email was sent but database storage failed
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your message! We will get back to you soon.',
            'note' => 'Message sent but could not be stored in database'
        ]);
    }
} else {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to send message. Please try again later or contact us directly at shreeyashcreations.2013@gmail.com'
    ]);
}
?> 