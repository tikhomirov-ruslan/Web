<?php
// Load movies data
$moviesData = file_get_contents('../data/movies.json');
$movies = json_decode($moviesData, true);

// Get featured movies (first 3)
$featuredMovies = array_slice($movies, 0, 3);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="main-content">
    <section class="banner">
        <div class="container">
            <h2>Welcome to MovieBase</h2>
            <p>Your ultimate destination for discovering and reviewing movies</p>
            <a href="catalog.php" class="btn" style="margin-top: 1rem;">Browse Movies</a>
        </div>
    </section>

    <div class="container">
        <section class="featured-movies">
            <h2>Featured Movies</h2>
            <div class="movie-grid">
                <?php foreach ($featuredMovies as $movie): ?>
                    <div class="movie-card">
                        <img src="../assets/images/<?php echo $movie['image']; ?>" alt="<?php echo $movie['title']; ?>" class="movie-poster">
                        <div class="movie-info">
                            <h3 class="movie-title"><?php echo $movie['title']; ?></h3>
                            <p class="movie-meta"><?php echo $movie['year']; ?> • <?php echo $movie['genre']; ?></p>
                            <p class="movie-rating">★ <?php echo $movie['rating']; ?>/10</p>
                            <a href="detail.php?id=<?php echo $movie['id']; ?>" class="btn" style="display: block; text-align: center; margin-top: 0.5rem;">View Details</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<?php include '../includes/footer.php'; ?>