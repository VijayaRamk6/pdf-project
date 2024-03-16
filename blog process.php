<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voice Recognition and PDF Generation</title>

    <!-- Link to the external stylesheet -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form id="voiceForm" action="process.php" method="post">
        <label for="topic">Enter Topic:</label>
        <input type="text" name="topic" id="topic" required>
        
        <!-- Voice input field -->
        <input type="text" id="voiceInput" name="voiceInput" placeholder="Speak topic" readonly>
        <button type="button" onclick="startVoiceRecognition()">Start Voice Recognition</button>
        
        <input type="submit" value="Generate PDF">
    </form>

    <script>
        function startVoiceRecognition() {
            const voiceInput = document.getElementById('voiceInput');
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

            if (SpeechRecognition) {
                const recognition = new SpeechRecognition();

                recognition.onresult = function (event) {
                    const result = event.results[0][0].transcript;
                    voiceInput.value = result;
                };

                recognition.start();
            } else {
                alert("Speech recognition is not supported in your browser.");
            }
        }
    </script>

    <?php include 'footer.php'; ?> <!-- Include footer -->
</body>
</html>
