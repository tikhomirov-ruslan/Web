<?php
$moviesData = file_get_contents('../data/movies.json');
$movies = json_decode($moviesData, true);

$featuredMovies = array_slice($movies, 0, 3);
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="main-content" style="">
    <section class="banner">
        <div class="container">
            <h2>Welcome to MovieBase</h2>
            <p>Your ultimate destination for discovering and reviewing movies</p>
            <a href="catalog.php" class="btn" style="margin-top: 1rem;">Browse Movies</a>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>