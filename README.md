                                                                              Task Management System

This project is a simple Task Management System that uses MySQL for the database and PHP for server-side logic. The system includes two main tables: `tasks` and `users`.

## Requirements
- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (e.g., Apache)

## Setup Instructions

# Step 1: Clone the Repository
    
    First, clone the repository to your local machine:
    
    git clone https://github.com/KrishnaDessai/SJ-innovation.git
    cd task-management-system

# Step 2: Configure Database Connection
    Open the <strong> "partials\_dbconnect.php" </strong> file in your preferred text editor and update the database connection details:
    
    $servername = "localhost"; // Replace with your server name
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password

## Step 3: Start Using the Application
    3.1 - Start the Local Server (e.g Apache)
    3.2 - Open the Browser and Put the URL (e.g http://127.0.0.1/sj_innovation/Login.php)

    ### note: make sure to register before you login.

# Step 5: Verify Database Creation
    Open your MySQL client (e.g., phpMyAdmin, MySQL Workbench) and verify that the database task_management_system and the tables tasks and users have been created.
    
    ## The structure of the tasks table should be:
    
    Field	Type	Null	Key	Default	Extra
    id	int	NO	PRI	NULL	auto_increment
    user_id	int	NO	MUL	NULL	
    title	varchar(255)	NO		NULL	
    description	text	NO		NULL	
    status	enum('pending', 'completed')	YES		pending	
    created_at	timestamp	NO		CURRENT_TIMESTAMP	DEFAULT_GENERATED
    
    ## The structure of the users table should be:
    
    Field	Type	Null	Key	Default	Extra
    id	int	NO	PRI	NULL	auto_increment
    email	varchar(45)	NO	UNI	NULL	
    password	varchar(255)	YES	UNI	NULL	
    date	datetime	NO		CURRENT_TIMESTAMP	DEFAULT_GENERATED
    firstname	varchar(50)	NO		NULL	
    lastname	varchar(50)	NO		NULL	
    contact	varchar(30)	YES		NULL	


Contact
For questions or support, please contact your-Krishna Dessai
email- krishnadessai8@gmail.com
phone no.-8806443619
