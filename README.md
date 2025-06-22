# Overivew

* Project Name: SkillHub
* Type: Full-stack Web Application
* Framework: Laravel 11 (PHP)
* Frontend: Laravel Blade
* Database: MySQL
* Version Control: Git + GitHub

## Objective:
To build a freelance marketplace where clients can post projects, and freelancers can bid, get hired, and both can add reviews.

## Functionality

### Authentication & Authorization
- Register/Login
- Role-based access control
### User Profile Management
- Profile description, location, experience
- Skills and tags
### Project Management
- Clients can post jobs with:
    Title, Description, Budget, Deadline, Category
### Proposal & Hiring System
- Freelancers submit:
    bid amount, estimated time
- Clients can:
    Review proposals, hire
- Statuses: Pending, Accepted, Rejected
### Reviews and Ratings
- Both sides rate each other post-project
- Public profile rating visible to other users
### Admin Panel
- Dashboard
- CRUD for categories, tags
### Project Search
- Search using Laravel Scout + MeiliSearch with filtering by category
