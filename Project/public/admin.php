<?php
// Load movies and reviews data
$moviesData = file_get_contents('../data/movies.json');
$movies = json_decode($moviesData, true);

$reviewsData = file_get_contents('../data/reviews.json');
$reviews = json_decode($reviewsData, true);

// Handle movie deletion
if (isset($_POST['delete_movie'])) {
    $movieId = intval($_POST['movie_id']);
    
    // Remove movie from array
    $movies = array_filter($movies, function($movie) use ($movieId) {
        return $movie['id'] != $movieId;
    });
    
    // Reset array keys
    $movies = array_values($movies);
    
    // Save back to file
    file_put_contents('../data/movies.json', json_encode($movies, JSON_PRETTY_PRINT));
    
    // Also remove associated reviews
    $reviews = array_filter($reviews, function($review) use ($movieId) {
        return $review['movie_id'] != $movieId;
    });
    
    // Reset array keys
    $reviews = array_values($reviews);
    
    // Save back to file
    file_put_contents('../data/reviews.json', json_encode($reviews, JSON_PRETTY_PRINT));
    
    // Reload page to reflect changes
    header('Location: admin.php');
    exit;
}

// Handle review deletion
if (isset($_POST['delete_review'])) {
    $reviewId = intval($_POST['review_id']);
    
    // Remove review from array
    $reviews = array_filter($reviews, function($review) use ($reviewId) {
        return $review['id'] != $reviewId;
    });
    
    // Reset array keys
    $reviews = array_values($reviews);
    
    // Save back to file
    file_put_contents('../data/reviews.json', json_encode($reviews, JSON_PRETTY_PRINT));
    
    // Reload page to reflect changes
    header('Location: admin.php');
    exit;
}

// Handle adding new movie
if (isset($_POST['add_movie'])) {
    $newMovie = [
        'id' => count($movies) + 1,
        'title' => trim($_POST['title']),
        'genre' => trim($_POST['genre']),
        'year' => intval($_POST['year']),
        'description' => trim($_POST['description']),
        'director' => trim($_POST['director']),
        'cast' => array_map('trim', explode(',', $_POST['cast'])),
        'duration' => trim($_POST['duration']),
        'rating' => floatval($_POST['rating']),
        'image' => trim($_POST['image'])
    ];
    
    // Add to movies array
    $movies[] = $newMovie;
    
    // Save back to file
    file_put_contents('../data/movies.json', json_encode($movies, JSON_PRETTY_PRINT));
    
    // Reload page to reflect changes
    header('Location: admin.php');
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="main-content">
    <div class="container">
        <h1>Admin Panel</h1>
        
        <div class="admin-panel">
            <div class="admin-section">
                <h3>Add New Movie</h3>
                <form method="POST">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <input type="text" id="genre" name="genre" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="year">Year</label>
                        <input type="number" id="year" name="year" min="1900" max="2023" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="director">Director</label>
                        <input type="text" id="director" name="director" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="cast">Cast (comma separated)</label>
                        <input type="text" id="cast" name="cast" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" id="duration" name="duration" placeholder="e.g., 148 min" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="rating">Rating (0-10)</label>
                        <input type="number" id="rating" name="rating" min="0" max="10" step="0.1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Image Filename</label>
                        <input type="text" id="image" name="image" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    
                    <button type="submit" name="add_movie" class="btn">Add Movie</button>
                </form>
            </div>
            
            <div class="admin-section">
                <h3>Manage Movies (<?php echo count($movies); ?>)</h3>
                
                <?php if (count($movies) > 0): ?>
                    <ul style="list-style: none; padding: 0;">
                        <?php foreach ($movies as $movie): ?>
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid #333;">
                                <strong><?php echo $movie['title']; ?></strong> (<?php echo $movie['year']; ?>)
                                <form method="POST" style="display: inline; margin-left: 1rem;">
                                    <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">
                                    <button type="submit" name="delete_movie" class="btn" style="background-color: #a00; padding: 0.25rem 0.5rem; font-size: 0.8rem;">Delete</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No movies in the database.</p>
                <?php endif; ?>
            </div>
            
            <div class="admin-section">
                <h3>Manage Reviews (<?php echo count($reviews); ?>)</h3>
                
                <?php if (count($reviews) > 0): ?>
                    <ul style="list-style: none; padding: 0;">
                        <?php foreach ($reviews as $review): ?>
                            <li style="padding: 0.5rem 0; border-bottom: 1px solid #333;">
                                <strong>Review #<?php echo $review['id']; ?></strong> for Movie ID: <?php echo $review['movie_id']; ?>
                                <br>
                                <em><?php echo $review['user']; ?> - ★ <?php echo $review['rating']; ?>/5</em>
                                <form method="POST" style="display: inline; margin-left: 1rem;">
                                    <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                                    <button type="submit" name="delete_review" class="btn" style="background-color: #a00; padding: 0.25rem 0.5rem; font-size: 0.8rem;">Delete</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No reviews in the database.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>