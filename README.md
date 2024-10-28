# Smart Parking System

The **Smart Parking System** is a web-based platform that streamlines parking space management. This system allows users to reserve and release parking spots, view their current and past reservations, and provides real-time updates on parking spot availability. The project is designed to enhance parking efficiency, reduce manual labor, and provide users with a hassle-free experience in managing their parking needs.

## Features

1.  **User Authentication**:

    - Secure login with sessions to authenticate users.

2.  **Parking Spot Reservation**:

    - Users can view all available parking spots and select one to reserve.
    - Spot reservation requires the user to provide their vehicle number for record-keeping.

3.  **Real-Time Spot Availability**:

    - Dynamic updates on parking spot availability with visual indicators for reserved and available spots.

4.  **Release Parking Spot**:

    - Users can release their reserved parking spots when they no longer need them.
    - Upon release, the parking spot information, including release timestamp, is moved to a dedicated "Previous Reservations" section for historical tracking.

5.  **Previous Reservations**:

    - Users can view their previously reserved spots along with reservation and release timestamps.

6.  **Responsive Notifications**:

    - Real-time pop-up notifications that inform the user about successful or failed actions (e.g., "Spot reserved successfully" in green and "Failed to release the parking spot" in red).

## Tech Stack

- **Frontend**:

  - **HTML/CSS**: Provides the structure and styling of the website.
  - **JavaScript**: Handles client-side interactivity and DOM manipulation.
  - **AJAX (Asynchronous JavaScript and XML)**: Enables asynchronous data fetching and updating without refreshing the page.

- **Backend**:

  - **PHP**: Manages server-side processing for authentication, reservation, and release functionalities.
  - **MongoDB**: A NoSQL database used to store and retrieve reservation data.

- **Other Libraries and Tools**:

  - **MongoDB PHP Library**: Facilitates interaction with MongoDB from the PHP backend.
  - **Make.com**: Optional tool for integrating additional automation workflows.

## Project Structure

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`  ├── config/  │   ├── database.php      # MongoDB connection setup  ├── public/  │   ├── index.html        # Homepage  │   ├── login.html        # User login page  │   ├── parking.html      # Main parking management interface  ├── src/  │   ├── contact.php       # Handles contact form submissions  │   ├── reserve.php       # Manages spot reservation  │   ├── release_spot.php  # Handles release of spots, moving data to "released" collection  │   ├── get_reserved_spots.php # Retrieves reserved and released spot data for display  ├── assets/  │   ├── css/  │   │   ├── style.css     # Styles for login and main pages  │   │   ├── contact.css   # Styles for the contact page  │   │   ├── parking.css   # Styles for parking page  │   ├── js/  │   │   ├── login.js      # Logic for login validation  │   │   ├── parking.js    # Manages reservation, release, and dynamic UI updates  │   └── images/           # Icons and images used across the website  └── README.md             # Project description and setup instructions  `

## Setup Instructions

1.  bashCopy codegit clone https://github.com/your-username/smart-parking-system.git
2.  **Install Dependencies**:

    - bashCopy codecomposer require mongodb/mongodb

3.  **Configure Database**:

    - Update the MongoDB connection details in config/database.php.

4.  **Run the Application**:

    - Set up a local or cloud-based server (e.g., Apache).
    - textCopy codehttp://localhost/smart-parking-system/public/index.html

## Usage Guide

1.  **Login**:

    - Access the login page and authenticate with valid credentials.

2.  **Reserve a Parking Spot**:

    - Navigate to the "Reserve Spot" section, choose an available spot, and input your vehicle number.

3.  **Release a Parking Spot**:

    - In the "Your Reserved Parking Spots" section, click "Release" to release your spot.
    - The released spot data is moved to the "Previous Reservations" section for future reference.

4.  **View Reservation History**:

    - Check the "Previous Reservations" section to view all released spots with timestamps for tracking.

## Future Improvements

- **Automated Spot Detection**: Integrate sensors to detect occupied and free spots automatically.
- **Enhanced Notifications**: Implement SMS or email notifications for reservation updates.
- **Reservation Reminders**: Send users reminders to release spots if they exceed certain time limits.

## License

This project is licensed under the MIT License. See the LICENSE file for more information.
