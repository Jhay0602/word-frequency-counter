<?php

// Function to tokenize the text into words
function tokenizeText($text) {
    $text = strtolower($text);
    $words = str_word_count($text, 1); // Tokenize into words
    return $words;
}

// Function to calculate word frequencies, excluding stop words
function calculateWordFrequencies($words, $stopWords) {
    $filteredWords = array_diff($words, $stopWords);
    $wordFrequencies = array_count_values($filteredWords);
    arsort($wordFrequencies); // Sort the array by frequency in descending order
    return $wordFrequencies;
}

// Function to display the result based on user's choices
function displayResult($wordFrequencies, $sortOrder, $displayLimit) {
    echo "<h2>Word Frequency Analysis</h2>";

    // Check if there are any words to display
    if (empty($wordFrequencies)) {
        echo "<p>No words to display.</p>";
        return;
    }

    echo "<table border='1'>";
    echo "<tr><th>Word</th><th>Frequency</th></tr>";

    // Limit the number of words to display
    $counter = 0;
    foreach ($wordFrequencies as $word => $frequency) {
        if ($counter < $displayLimit) {
            echo "<tr><td>$word</td><td>$frequency</td></tr>";
            $counter++;
        } else {
            break;
        }
    }

    echo "</table>";
}

// Sample stop words list
$stopWords = array("the", "and", "in", "to", "of", "a", "is", "for", "on", "with");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the textarea
    $userInput = $_POST["textArea"];

    // Tokenize the text
    $words = tokenizeText($userInput);

    // Calculate word frequencies excluding stop words
    $wordFrequencies = calculateWordFrequencies($words, $stopWords);

    // Determine sorting order
    $sortOrder = ($_POST["sortOrder"] == "asc") ? SORT_ASC : SORT_DESC;

    // Display the result based on user's choices
    displayResult($wordFrequencies, $sortOrder, $_POST["displayLimit"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Frequency Counter</title>
</head>
<body>
    <h1>Word Frequency Counter</h1>
    <form method="post" action="">
        <label for="textArea">Enter text:</label><br>
        <textarea id="textArea" name="textArea" rows="10" cols="50"></textarea><br>
        <label for="sortOrder">Sort Order:</label>
        <select id="sortOrder" name="sortOrder">
            <option value="desc">Descending</option>
            <option value="asc">Ascending</option>
        </select><br>
        <label for="displayLimit">Display Limit:</label>
        <input type="number" id="displayLimit" name="displayLimit" min="1" value="10"><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
