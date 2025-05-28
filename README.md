# 📝 To-Do List Website

The **To-Do List Website** is a personal task manager that helps you stay organized through an intuitive web interface. Built using **PHP** and **MySQL** with **XAMPP**, this app features a responsive design powered by **Bootstrap**, ideal for daily productivity.

---

## ✅ Features

- 🔐 **User Authentication**  
  Secure login and logout system. Local execution supported via XAMPP.

- 🗃️ **Task Management (CRUD)**  
  Add, edit, delete, and view tasks. Tasks are sorted by **priority date** and grouped by **completion status**.

- 🧭 **Smart Navigation**  
  Switch between completed and incomplete tasks with scroll-based navigation.

- 📱 **Responsive Design**  
  Fully responsive design that ensures a seamless experience across desktops, tablets, and mobile devices.

---

## 🌐 Website Preview

<table>
  <tr>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/a2c420d9-85da-406c-8a49-3664a691c1d1" width="450px"/><br>
      <strong>Login Page</strong>
    </td>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/dd285baf-fd69-471d-8d48-3293c92df720" width="450px"/><br>
      <strong>Task Management (CRUD)</strong>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/df9b15fb-5e12-46c2-adee-bd5b178ece49" width="450px"/><br>
      <strong>Task Navigation</strong>
    </td>
    <td align="center">
      <img src="https://github.com/user-attachments/assets/5da94c03-7003-43f4-a4b7-63d6732a90ff" width=450px"/><br>
      <strong>Logout Page</strong>
    </td>
  </tr>
</table>

---

## 🛠 Tech Stack

| Layer      | Technology        |
|------------|-------------------|
| Frontend   | HTML, CSS, Bootstrap |
| Backend    | PHP (Procedural or OOP) |
| Database   | MySQL (via XAMPP) |
| Server     | Apache (XAMPP)    |

---

## 🚀 Getting Started

1. **Clone this repository**:
   ```bash
   git clone https://github.com/yourusername/todo-list-php.git
   ```

2. **Move the folder into your XAMPP directory**:
   - Copy `todo-list-php` to `htdocs` inside your XAMPP installation.

3. **Start XAMPP**:
   - Launch Apache and MySQL via the XAMPP Control Panel.

4. **Create the MySQL database**:
   - Go to [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Click on the **Databases** tab.
   - Create a new database named: `todolist_database`

5. **Import the SQL file**:
   - Click the newly created `todolist_database`.
   - Go to **Import**, choose the file `todolist.sql` from the project directory.
   - Click **Go** to execute the import.

6. **Access your app**:
   ```bash
   http://localhost/todo-list-php/
   ```

---

## 🔒 Security Note

- Passwords are encrypted using `md5()` for basic protection.
- For production, consider upgrading to more secure hashing methods like `password_hash()`.

---

### 🔑 Login Page  
![Login Page](https://github.com/user-attachments/assets/a2c420d9-85da-406c-8a49-3664a691c1d1)

### 📝 Task Management (CRUD)  
![CRUD](https://github.com/user-attachments/assets/dd285baf-fd69-471d-8d48-3293c92df720)

### 🧭 Navigation (Complete/Incomplete Tasks)  
![Navigation](https://github.com/user-attachments/assets/5da94c03-7003-43f4-a4b7-63d6732a90ff)

### 🚪 Logout Page  
![Logout](https://github.com/user-attachments/assets/df9b15fb-5e12-46c2-adee-bd5b178ece49)

---

## 🤝 Contributing

Feel free to fork this project, star ⭐ it, and submit pull requests. Suggestions and issues are welcome!

---
