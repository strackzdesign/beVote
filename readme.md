# beVote - Features #

- Login/Registration panel
- Vote System
- Basic Admin System //Add and Remove Candidates from the Database

# Install #

- Install the database before starting the website itself.
- Change the database and user if needed. //fuctions.php - connectDB()
- Good Luck !!

# System Functions (functions.php) #

- connectDB() //Returns the connection to the database
- checkAdmin($user_name) //U can create conditionals to check if the $user_name = $_SESSION['session_user'] is admin, the function will return true if the user is admin.
