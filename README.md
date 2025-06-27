# Overivew

* Project Name: SkillHub
* Type: Full-stack Web Application
* Framework: Laravel 11 (PHP)
* Frontend: Laravel Blade & Tailwind CSS & Livewire & Alpine.js & Livewire Flux
* Database: MySQL
* Version Control: Git + GitHub

## Objective:
To build a freelance marketplace where clients can post projects, and freelancers can bid, get hired, upload files, and both can add reviews.

## Functionality

### Authentication & Authorization
- Register/Login
- Role-based access control
- Email verification
### User Profile Management
- Profile description, location, experience, avatar
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
### File Upload
- Freelancers upload files
- System sends email notifications in a background job
- Clients or other freelancers can download
### Reviews and Ratings
- Both sides rate each other post-project
- Public profile rating visible to other users
### Admin Panel
- Dashboard
- CRUD for categories, tags, posts
### Project Search
- Search using Laravel Scout + MeiliSearch with filtering by category, min/max budget, deadline, and created date

## Screeshots

![screenshot1](/screenshots/login.png)

![screenshot2](/screenshots/categories.png)

![screenshot3](/screenshots/projects.png)

![screenshot4](/screenshots/proposals.png)

![screenshot5](/screenshots/freelancers.png)

![screenshot6](/screenshots/search.png)

![screenshot7](/screenshots/create_proposal.png)