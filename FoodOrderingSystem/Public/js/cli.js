const readline = require('readline');
const axios = require('axios');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
});

// Function to prompt user for input
const promptUser = (query) => {
    return new Promise((resolve) => {
        rl.question(query, (answer) => {
            resolve(answer);
        });
    }); 
};

// Function to display menu options
const displayMenu = () => {
    console.log(`
  1. View all users
  2. Add a new user
  3. Update a user
  4. Delete a user
  5. View all admins
  6. Add a new admin
  7. Update an admin
  8. Delete an admin
  9. Exit
  `);
};

// Function to handle the user's choice
const handleChoice = async (choice) => {
    switch (choice) {
        case '1':
            const users = await axios.get('http://localhost:3000/users');
            console.log(JSON.stringify(users.data, null, 2));
            break;
        case '2':
            const username = await promptUser('Username: ');
            const email = await promptUser('Email: ');
            const phone_number = await promptUser('Phone number: ');
            const password = await promptUser('Password: ');
            const status = await promptUser('Status (Active/Inactive): ');

            await axios.post('http://localhost:3000/users', {
                username,
                email,
                phone_number,
                password,
                status,
            });
            console.log('User added successfully!');
            break;
        case '3':
            const userIdToUpdate = await promptUser('User ID to update: ');
            const updatedUsername = await promptUser('New Username: ');
            const updatedEmail = await promptUser('New Email: ');
            const updatedPhoneNumber = await promptUser('New Phone number: ');
            const updatedStatus = await promptUser('New Status (Active/Inactive/Banned): ');

            await axios.put(`http://localhost:3000/users/${userIdToUpdate}`, {
                username: updatedUsername,
                email: updatedEmail,
                phone_number: updatedPhoneNumber,
                status: updatedStatus,
            });
            console.log('User updated successfully!');
            break;
        case '4':
            const userIdToDelete = await promptUser('User ID to delete: ');
            await axios.delete(`http://localhost:3000/users/${userIdToDelete}`);
            console.log('User deleted successfully!');
            break;
        case '5':
            const admins = await axios.get('http://localhost:3000/admins');
            console.log(JSON.stringify(admins.data, null, 2));
            break;
        case '6':
            const adminUsername = await promptUser('Admin Username: ');
            const adminEmail = await promptUser('Admin Email: ');
            const adminPhoneNumber = await promptUser('Admin Phone number: ');
            const adminPassword = await promptUser('Admin Password: ');
            const adminRole = await promptUser('Admin Role(Admin/Moderator/Staff): ');

            await axios.post('http://localhost:3000/admins', {
                username: adminUsername,
                email: adminEmail,
                phone_number: adminPhoneNumber,
                password: adminPassword,
                role: adminRole,
            });
            console.log('Admin added successfully!');
            break;
        case '7':
            const adminIdToUpdate = await promptUser('Admin ID to update: ');
            const updatedAdminUsername = await promptUser('New Admin Username: ');
            const updatedAdminEmail = await promptUser('New Admin Email: ');
            const updatedAdminPhoneNumber = await promptUser('New Admin Phone number: ');
            const updatedAdminRole = await promptUser('New Admin Role(Admin/Moderator/Staff): ');

            await axios.put(`http://localhost:3000/admins/${adminIdToUpdate}`, {
                usernameAdmin: updatedAdminUsername,
                emailAdmin: updatedAdminEmail,
                phoneAdmin: updatedAdminPhoneNumber,
                role: updatedAdminRole,
            });
            console.log('Admin updated successfully!');
            break;
        case '8':
            const adminIdToDelete = await promptUser('Admin ID to delete: ');
            await axios.delete(`http://localhost:3000/admins/${adminIdToDelete}`);
            console.log('Admin deleted successfully!');
            break;
        case '9':
            rl.close();
            return;
        default:
            console.log('Invalid choice, please try again.');
            break;
    }
    main(); // Loop back to the main menu
};

// Main function to display menu and handle user choices
const main = async () => {
    displayMenu();
    const choice = await promptUser('Enter your choice: ');
    await handleChoice(choice);
};

main();
