<?php
// Load movies data
$moviesData = file_get_contents('../data/movies.json');
$movies = json_decode($moviesData, true);

// Get unique genres for filter
$genres = array_unique(array_column($movies, 'genre'));

// Filter movies based on search and filter parameters
$filteredMovies = $movies;

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = strtolower($_GET['search']);
    $filteredMovies = array_filter($filteredMovies, function($movie) use ($searchTerm) {
        return strpos(strtolower($movie['title']), $searchTerm) !== false;
    });
}

if (isset($_GET['genre']) && !empty($_GET['genre'])) {
    $filteredMovies = array_filter($filteredMovies, function($movie) {
        return $movie['genre'] == $_GET['genre'];
    });
}

if (isset($_GET['year']) && !empty($_GET['year'])) {
    $filteredMovies = array_filter($filteredMovies, function($movie) {
        return $movie['year'] == $_GET['year'];
    });
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="main-content">
    <div class="container">
        <h1>Movie Catalog</h1>
        
        <section class="filter-section">
            <form method="GET" class="filter-form">
                <div class="filter-group">
                    <label for="search">Search by Title</label>
                    <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
                
                <div class="filter-group">
                    <label for="genre">Filter by Genre</label>
                    <select id="genre" name="genre">
                        <option value="">All Genres</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?php echo $genre; ?>" <?php echo (isset($_GET['genre']) && $_GET['genre'] == $genre) ? 'selected' : ''; ?>>
                                <?php echo $genre; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="year">Filter by Year</label>
                    <input type="number" id="year" name="year" min="1900" max="2023" value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ''; ?>">
                </div>
                
                <div class="filter-group">
                    <button type="submit" class="btn">Apply Filters</button>
                    <a href="catalog.php" class="btn" style="background-color: #666; margin-left: 0.5rem;">Reset</a>
                </div>
            </form>
        </section>
        
        <section class="movie-catalog">
            <h2><?php echo count($filteredMovies); ?> Movies Found</h2>
            
            <?php if (count($filteredMovies) > 0): ?>
                <div class="movie-grid">
                    <?php foreach ($filteredMovies as $movie): ?>
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
            <?php else: ?>
                <p>No movies found matching your criteria.</p>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php include '../includes/footer.php'; ?>