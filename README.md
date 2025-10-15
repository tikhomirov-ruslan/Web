# 🎬 MovieBase 
Interactive Movie Information & Review Website
# 📘 Project Topic and Team Members
    Project Title: MovieBase
    Topic: A dynamic website for browsing movies, viewing detailed information, and posting user reviews.

# Team Members:
    💻 Shakhizada Zhansulu – front,back dev
    💻 Tikhomirov Ruslan – front,back dev

# 🧩Main features:
    🔍 Movie Catalog: Users can browse through available movies with posters, titles, and short summaries.
    📖 Movie Details Page: Displays extended information such as release date, genre, description and reviews from users.
    💬 Reviews Section: Users can leave feedback and rate movies.
    📦 JSON Data Handling: All movie information and reviews are read from and written to JSON files using PHP.

# 🏗️ Project Structure:
    project
    ├── assets
    │   ├── css
    │   │   └── style.css
    │   ├── images
    │   │   ├── dark_knight.jpg
    │   │   ├── inception.jpg
    │   │   ├── pulp_fiction.jpg
    │   │   └── shawshank.jpg
    ├── data
    │   ├── movies.json
    │   └── reviews.json
    ├── includes
    │   ├── footer.php
    │   ├── header.php
    │   └── navigation.php
    ├── public
    │   ├── admin.php
    │   ├── catalog.php
    │   ├── detail.php
    │   ├── form.php
    │   └── index.php
    └── README.md

# 🏠 Home Page
<img width="1900" height="968" alt="image" src="https://github.com/user-attachments/assets/9f0764c8-678e-4ae6-96f0-7df1f62a858c" />

# 🎥 Movie List Page
<img width="1892" height="983" alt="image" src="https://github.com/user-attachments/assets/102e092e-897b-49b2-9d97-941208ee6558" />

# 🎥 Movie Details Page
<img width="1899" height="966" alt="image" src="https://github.com/user-attachments/assets/33d2a865-2ccc-4e1e-b8f3-fb4ffbfebb18" />

# 💬 Review Submission
<img width="1902" height="979" alt="image" src="https://github.com/user-attachments/assets/46c0cace-18bb-4942-af77-da7908aeca41" />

# 🔳 Admin Panel
<img width="1893" height="975" alt="image" src="https://github.com/user-attachments/assets/45c9d443-16f0-4989-be10-e1dfb64b3300" />

# 🧾 Short desc about JSON data
All movie information is stored in a JSON file (movies.json).
Each movie has fields such as id, title, genre, year, description, director, cast, duration, rating, and image.

    {
            "id": 1,
            "title": "Inception",
            "genre": "Sci-Fi",
            "year": 2010,
            "description": "A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.",
            "director": "Christopher Nolan",
            "cast": [
                "Leonardo DiCaprio",
                "Joseph Gordon-Levitt",
                "Ellen Page"
            ],
            "duration": "148 min",
            "rating": 8.8,
            "image": "inception.jpg"
        },    

All review information is stored in a JSON file (reviews.json)
This file stores all movie details, including: id, title, genre, year, description, director, cast, duration, rating, and image.

     {
        "id": 1,
        "movie_id": 1,
        "user": "Alice",
        "rating": 5,
        "comment": "Mind-blowing concept and execution! Nolan at his best.",
        "date": "2023-10-15"
    },
