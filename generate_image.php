<?php
// Replace this with your actual OpenAI API key
$openai_api_key = OpenAI_API_KEY;

$data = json_decode(file_get_contents("php://input"), true);
$event_name = $data['event_name'] ?? '';
$event_description = $data['event_description'] ?? '';

$prompt = "Create a vibrant and attractive event poster for an event titled '{$event_name}' with theme: {$event_description}.";

$ch = curl_init();

sleep(5);
// curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/images/generations");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     "Content-Type: application/json",
//     "Authorization: Bearer {$openai_api_key}"
// ]);

// $payload = json_encode([
//     "model" => "dall-e-3",
//     "prompt" => $prompt,
//     "n" => 1,
//     "size" => "1024x1024",
//     "response_format" => "url"
// ]);

// curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// $response = curl_exec($ch);
// curl_close($ch);

// $result = json_decode($response, true);

$image_url = "https://cdn.pixabay.com/photo/2024/05/26/10/15/bird-8788491_1280.jpg";//$result['data'][0]['url'] ?? null;

// Download image
$image_contents = file_get_contents($image_url);
if ($image_contents === false) {
    echo json_encode(['error' => 'Failed to download image']);
    exit;
}

// Generate unique filename
$slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($event_name));
$filename = '' . $slug . '-' . time() . '.png';

// Save to local folder
file_put_contents($filename, $image_contents);

echo json_encode(["image_url" => $filename]);

?>