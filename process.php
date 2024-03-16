<?php
// process.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic = isset($_POST["topic"]) ? $_POST["topic"] : '';
    $voiceInput = isset($_POST["voiceInput"]) ? $_POST["voiceInput"] : '';

    // Use voice input if available; otherwise, use text input
    $selectedTopic = $voiceInput ? $voiceInput : $topic;

    // Fetch content from Wikipedia using the Wikipedia API.
    $wikipediaEndpoint = "https://en.wikipedia.org/w/api.php";
    $params = [
        'action' => 'query',
        'format' => 'json',
        'titles' => $selectedTopic,
        'prop' => 'extracts',
        'exintro' => true,
        'explaintext' => true,
    ];

    $url = $wikipediaEndpoint . '?' . http_build_query($params);
    $response = json_decode(file_get_contents($url), true);

    // Check if the 'extract' key exists in the response.
    if (isset($response['query']['pages'])) {
        $pages = array_values($response['query']['pages']);

        // Check if the 'extract' key exists in the response.
        if (isset($pages[0]['extract'])) {
            $content = $pages[0]['extract'];

            // Generate PDF with the fetched content.
            generatePDF($selectedTopic, $content);
        } else {
            echo "Content not found in the API response.";
        }
    } else {
        echo "Topic not found on Wikipedia.";
    }
}

function generatePDF($topic, $content) {
    // Implement PDF generation logic using a library like FPDF, TCPDF, or mpdf.
    // Example using FPDF:
    require('fpdf186/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Blog: ' . $topic);

    // Add the content to the PDF.
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $content);

    $pdf->Output('blog_' . $topic . '.pdf', 'D');
    exit;
}
?>
