# TaskManagement

## Description
create a web application using PHP Laravel that adheres to the specifications below:

1. Core Application Features

User Management:

Develop a Role-Based Access Control (RBAC) system with three roles: Admin, Manager, and User.
Implement a registration and login system with proper validation.
Ensure password hashing and secure session handling.
Task Management:

Build a task management system with the following:
A Task entity with attributes: title, description, status (pending, in-progress, completed), priority (low, medium, high), and assigned_user.
A manager can create, update, and assign tasks to users.
Users can update the status of tasks assigned to them.
An admin can view all tasks.
Reporting:

Create a dashboard for admins that includes:
Total number of users (by role).
Total number of tasks (grouped by status and priority).
Average task completion time.
2. Database Design

Use proper relational database design principles:
Implement relationships (e.g., One-to-Many, Many-to-Many).
Use migrations and seeders to populate sample data.
3. Code Quality and Architecture

Follow SOLID principles and use Laravel design patterns (e.g., Repository Pattern, Service Layer).
Ensure clean, reusable, and modular code.
4. Problem-Solving and Logic

Include the following:

A feature to calculate task efficiency:
Efficiency = (Completed Tasks / Total Tasks) × 100.
Write a function to assign tasks in a round-robin manner to users based on their current workload (number of active tasks).
5. Testing

Write unit tests for at least two features using PHPUnit.
Bonus: Include feature tests for the task management system.
6. Bonus (Optional)

Implement a notification system (e.g., email notifications) when tasks are assigned or updated.

## Installation
Steps to install and set up the project locally:
```bash
git clone https://github.com/madonnaredakamel/TaskManagementApp.git
cd TaskManagementApp
composer install
php artisan migrate
php artisan DB:seed

