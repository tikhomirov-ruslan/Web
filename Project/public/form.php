<?php
// Load movies data
$moviesData = file_get_contents('../data/movies.json');
$movies = json_decode($moviesData, true);

// Load reviews data
$reviewsData = file_get_contents('../data/reviews.json');
$reviews = json_decode($reviewsData, true);

// Check if form was submitted
$submissionSuccess = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $movieId = isset($_POST['movie_id']) ? intval($_POST['movie_id']) : 0;
    $user = trim($_POST['user'] ?? '');
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comment = trim($_POST['comment'] ?? '');
    
    // Validation
    if ($movieId <= 0) {
        $errors[] = "Please select a movie.";
    }
    
    if (empty($user)) {
        $errors[] = "Please enter your name.";
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Please select a valid rating (1-5).";
    }
    
    if (empty($comment)) {
        $errors[] = "Please enter your review comment.";
    }
    
    // If no errors, save the review
    if (empty($errors)) {
        // Create new review
        $newReview = [
            'id' => count($reviews) + 1,
            'movie_id' => $movieId,
            'user' => $user,
            'rating' => $rating,
            'comment' => $comment,
            'date' => date('Y-m-d')
        ];
        
        // Add to reviews array
        $reviews[] = $newReview;
        
        // Save back to JSON file
        file_put_contents('../data/reviews.json', json_encode($reviews, JSON_PRETTY_PRINT));
        
        $submissionSuccess = true;
    }
}

// Get movie ID from URL if provided
$selectedMovieId = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : 0;
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="main-content">
    <div class="container">
        <h1>Submit a Movie Review</h1>
        
        <?php if ($submissionSuccess): ?>
            <div style="background-color: #1a3c1a; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <p>Thank you for your review! It has been submitted successfully.</p>
                <a href="detail.php?id=<?php echo $movieId; ?>" class="btn">View Movie</a>
                <a href="form.php" class="btn" style="background-color: #666;">Submit Another Review</a>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div style="background-color: #3c1a1a; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                <h3>Please fix the following errors:</h3>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="movie_id">Select Movie</label>
                    <select id="movie_id" name="movie_id" required>
                        <option value="">Choose a movie...</option>
                        <?php foreach ($movies as $movie): ?>
                            <option value="<?php echo $movie['id']; ?>" 
                                <?php echo ($selectedMovieId == $movie['id'] || (isset($movieId) && $movieId == $movie['id'])) ? 'selected' : ''; ?>>
                                <?php echo $movie['title']; ?> (<?php echo $movie['year']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="user">Your Name</label>
                    <input type="text" id="user" name="user" value="<?php echo isset($user) ? htmlspecialchars($user) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="rating">Your Rating (1-5 stars)</label>
                    <select id="rating" name="rating" required>
                        <option value="">Select rating...</option>
                        <option value="1" <?php echo (isset($rating) && $rating == 1) ? 'selected' : ''; ?>>1 ★ - Poor</option>
                        <option value="2" <?php echo (isset($rating) && $rating == 2) ? 'selected' : ''; ?>>2 ★★ - Fair</option>
                        <option value="3" <?php echo (isset($rating) && $rating == 3) ? 'selected' : ''; ?>>3 ★★★ - Good</option>
                        <option value="4" <?php echo (isset($rating) && $rating == 4) ? 'selected' : ''; ?>>4 ★★★★ - Very Good</option>
                        <option value="5" <?php echo (isset($rating) && $rating == 5) ? 'selected' : ''; ?>>5 ★★★★★ - Excellent</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="comment">Your Review</label>
                    <textarea id="comment" name="comment" required><?php echo isset($comment) ? htmlspecialchars($comment) : ''; ?></textarea>
                </div>
                
                <button type="submit" class="btn">Submit Review</button>
            </form>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>