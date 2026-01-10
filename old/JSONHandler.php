<?php
function cust_JSONReqHandler($expectedAction) {
    // Checks if it's json
    $data = json_decode(file_get_contents('php://input'), true);
    if ($_SERVER["REQUEST_METHOD"] === "POST"
    and $data) {
        $action = $data["action"] ?? null;
        if ($action !== $expectedAction) {
            if ($action) {
                return;
            } else {
                $message = "Erroneous JSON";
                echo json_encode($message); 
                return;
            };
        };
        return $data;
    };
};
?>