<?php
$moviesData = file_get_contents('../data/movies.json');
$movies = json_decode($moviesData, true);

$reviewsData = file_get_contents('../data/reviews.json');
$reviews = json_decode($reviewsData, true);

$movieId = isset($_GET['id']) ? intval($_GET['id']) : 1;

$movie = null;
foreach ($movies as $m) {
    if ($m['id'] == $movieId) {
        $movie = $m;
        break;
    }
}

if (!$movie) {
    header('Location: catalog.php');
    exit;
}

$movieReviews = array_filter($reviews, function($review) use ($movieId) {
    return $review['movie_id'] == $movieId;
});
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="main-content">
    <div class="container">
        <section class="movie-detail">
            <div class="movie-detail-poster">
                <img src="../assets/images/<?php echo $movie['image']; ?>" alt="<?php echo $movie['title']; ?>" style="width: 100%; border-radius: 8px;">
            </div>
            
            <div class="movie-detail-info">
                <h2><?php echo $movie['title']; ?></h2>
                
                <div class="movie-detail-meta">
                    <p><strong>Year:</strong> <?php echo $movie['year']; ?></p>
                    <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
                    <p><strong>Director:</strong> <?php echo $movie['director']; ?></p>
                    <p><strong>Duration:</strong> <?php echo $movie['duration']; ?></p>
                    <p><strong>Rating:</strong> <span class="movie-rating">★ <?php echo $movie['rating']; ?>/10</span></p>
                    <p><strong>Cast:</strong> <?php echo implode(', ', $movie['cast']); ?></p>
                </div>
                
                <div class="movie-description">
                    <h3>Synopsis</h3>
                    <p><?php echo $movie['description']; ?></p>
                </div>
                
                <div style="margin-top: 1.5rem;">
                    <a href="form.php?movie_id=<?php echo $movie['id']; ?>" class="btn">Write a Review</a>
                </div>
            </div>
        </section>
        
        <section class="reviews-section">
            <h2>User Reviews</h2>
            
            <?php if (count($movieReviews) > 0): ?>
                <?php foreach ($movieReviews as $review): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <span class="review-user"><?php echo $review['user']; ?></span>
                            <span class="review-rating">★ <?php echo $review['rating']; ?>/5</span>
                        </div>
                        <p><?php echo $review['comment']; ?></p>
                        <div class="review-date"><?php echo $review['date']; ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to <a href="form.php?movie_id=<?php echo $movie['id']; ?>">write a review</a>!</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include '../includes/footer.php'; ?>